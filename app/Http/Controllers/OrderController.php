<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Table;
use Mike42\Escpos\Printer;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{

    public $school_name;

    public function __construct()
    {
        $this->school_name = "Universidad de Dagupan";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order-details');
    }

    public function show(Order $order)
    {
        return view('show-order', compact('order'));
    }

    public function printReceipt(Order $order, $reprint = 0)
    {
        try {
            $config = Configuration::first();
            DB::beginTransaction();

            $date = now()->toDateTimeString();
            $foods = [];
            $drinks = [];
            $new = [];
            foreach ($order->orderDetails as $i) {
                echo $i->printed."<br>";
                if($i->printed == false){
                    $description = '';
                    if($i->isDrink()){

                        $drinks[] = new item($i->dish->name, $i->pcs, $description, $i->note);
                    }

                    if($i->isFood()){
                        $dishName = $i->dish->name;

                        $foods[] = new item($dishName, $i->pcs, $description, $i->note);
                    }

                    $new[] = $i->id;
                    $i->printed = true;
                    $i->save();
                }

            }



            $length = 60;

            if(count($foods) > 0) {

                // Enter the share name for your USB printer here
                //$connector1 = new WindowsPrintConnector("smb://L403-PC38/POS-58");
                $connector1 = new WindowsPrintConnector("POS-58");
                // $connector1 = new NetworkPrintConnector($config->network_printer, 9100);

                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector1);
                $printer->initialize();
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setEmphasis(true);
                $printer->text("Kitchen\n");
                $printer->text("Order Number: " . $order->order_number . "\n");
                $printer->text($order->table()->name ?? '');
                $printer->setEmphasis(false);
                $printer->text("\n");
                $printer->text($order->action . "\n");
                $printer->text($date . "\n");
                $printer->text("Server: " . $order->waiter->full_name . "\n");
                $printer->feed(2);
                $printer->setJustification(Printer::JUSTIFY_LEFT);

                foreach ($foods as $o) {
                    $printer->text($o->getAsString($length));
                }
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text('---------------------');

                $printer->feed(4);

                $printer->cut();

                /* Close printer */
                $printer->close();
            }


            if(count($drinks) > 0 ){
                $connector2 = new WindowsPrintConnector("POS-58-BAR");

                $printer2 = new Printer($connector2);
                $printer2->setJustification(Printer::JUSTIFY_CENTER);
                $printer2->setEmphasis(true);
                $printer2->text("Bar\n");
                $printer2->text("Order Number: " . $order->order_number . "\n");
                $printer2->text($order->table()->name ?? '');
                $printer2->setEmphasis(false);
                $printer2->text("\n");
                $printer2->text($order->action . "\n");
                $printer2->text($date . "\n");
                $printer2->text("Server: " . $order->waiter->full_name . "\n");
                $printer2->feed(2);
                $printer2->setJustification(Printer::JUSTIFY_LEFT);
                foreach ($drinks as $o) {
                    $printer2->text($o->getAsString($length));
                }
                $printer2->setJustification(Printer::JUSTIFY_CENTER);
                $printer2->text('---------------------');

                $printer2->feed(4);

                $printer2->cut();

                /* Close printer */
                $printer2->close();
            }

            DB::commit();

        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
            DB::rollback();
        }
    }


    public function printKitchen(Order $order, $reprint = 0)
    {

        try {

            DB::beginTransaction();

            $date = now()->toDateTimeString();
            $foods = [];
            $new = [];
            foreach ($order->orderDetails as $i) {

                // if($i->printed == false){
                    $description = '';


                    if($i->isFood()){
                        $dishName = $i->dish->name;
                        if($i->sideDishes) {
                            foreach($i->sideDishes as $side){
                                $description .= "\n side: ".$side->dish->name;
                            }
                        }

                        $foods[] = new item($dishName, $i->pcs, $description, $i->note);

                    }

                    $new[] = $i->id;
                    $i->printed = true;
                    $i->save();
                // }

            }


            $length = 60;

            if(count($foods) > 0) {

                // Enter the share name for your USB printer here
                //$connector1 = new WindowsPrintConnector("smb://L403-PC38/POS-58");
                $profile = CapabilityProfile::load("POS-5890");
                // $connector1 = new RawbtPrintConnector();
                $connector1 = new NetworkPrintConnector(Configuration::first()->network_printer, 9100);

                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector1, $profile);
                $printer->initialize();
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setEmphasis(true);
                $printer->text("Kitchen\n");
                $printer->text("Order Number: " . $order->order_number . "\n");
                $printer->text($order->table()->name ?? '');
                $printer->setEmphasis(false);
                $printer->text("\n");
                $printer->text($order->action . "\n");
                $printer->text($date . "\n");
                $printer->text("Server: " . $order->waiter->full_name . "\n");
                $printer->feed(2);
                $printer->setJustification(Printer::JUSTIFY_LEFT);

                foreach ($foods as $o) {
                    $printer->text($o->getAsString($length));
                }
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text('---------------------');

                $printer->feed(4);

                $printer->cut();

                $printer->close();
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }

        // // $connector = new RawbtPrintConnector();
        // $connector = new NetworkPrintConnector('192.168.100.5', 9100);
        // $profile = CapabilityProfile::load("POS-5890");
        // $printer = new Printer($connector, $profile);
        // $printer -> text("Hello world!\n");
        // $printer -> cut();
        // $printer->close();
    }

    public function printBill(Order $order)
    {
        try {
            $date = now()->toDateTimeString();
            $items = [];
            foreach ($order->orderDetails as $i) {
                $items[] = new receiptItem($i->dish->name." (". $i->dish->properties .") X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            foreach ($order->customOrderDetails as $i) {
                $items[] = new receiptItem($i->name." (". $i->description .") X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            $cash = new receiptItem('Cash', number_format($order->cash, 2, '.', ','));
            $change = new receiptItem('Change', number_format($order->change, 2, '.', ','));
            $totalPrice = new receiptItem('Total' , number_format($order->totalPriceWithoutDiscount(), 2, '.', ','));

            // Enter the share name for your USB printer here
            // $connector = new WindowsPrintConnector("POS-58-BAR");
            $connector = new WindowsPrintConnector("POS-58");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("CANTEEN\n");
            $printer->selectPrintMode();
            $printer->text("{$this->school_name}\n");
            $printer->setEmphasis(false);
            $printer->feed();

            /* Title of receipt */

            $printer->setEmphasis(true);
            $printer->text("RECEIPT\n");
            $printer->setEmphasis(false);

            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->feed(2);

            $printer->setFont(Printer::FONT_B);

            /* Items */
            $length = 80;
            foreach ($items as $o) {
                $printer->text($o->getAsString($length));
            }
            $printer->feed();

            /* Tax and total */


            $printer->selectPrintMode();
            $printer->text($totalPrice->getAsString($length));
            $printer->text($cash->getAsString($length));
            $printer->text($change->getAsString($length));

            $printer->feed(2);

            $printer->setFont(Printer::FONT_A);


            /* Footer */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("This is not the official receipt\n");
            $printer->feed();
            $printer->text("-----------------------\n");
            $printer->text($date . "\n");

            $printer->feed(3);

            $printer->cut();

            /* Close printer */
            $printer->close();


        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

    public function printPurchasOrder(Order $order)
    {
        try {
            $date = now()->toDateTimeString();
            $items = [];
            foreach ($order->orderDetails as $i) {
                $items[] = new receiptItem($i->dish->name." (". $i->dish->properties .") X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            foreach ($order->customOrderDetails as $i) {
                $items[] = new receiptItem($i->name." (". $i->description .") X ".$i->pcs, number_format($i->price, 2, '.', ','));
            }

            $cash = new receiptItem('Cash', number_format($order->cash, 2, '.', ','));
            $change = new receiptItem('Change', number_format($order->change, 2, '.', ','));
            $totalPrice = new receiptItem('Total' , number_format($order->totalPriceWithoutDiscount(), 2, '.', ','));

            // Enter the share name for your USB printer here
            // $connector = new WindowsPrintConnector("POS-58-BAR");
            $connector = new WindowsPrintConnector("POS-58");

            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text("CANTEEN\n");
            $printer->selectPrintMode();
            $printer->text("{$this->school_name}\n");
            $printer->setEmphasis(false);
            $printer->feed();

            /* Title of receipt */

            $printer->setEmphasis(true);
            $printer->text("RECEIPT\n");
            $printer->setEmphasis(false);

            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->feed(2);

            $printer->setFont(Printer::FONT_B);

            /* Items */
            $length = 80;
            foreach ($items as $o) {
                $printer->text($o->getAsString($length));
            }
            $printer->feed();

            /* Tax and total */


            $printer->selectPrintMode();
            $printer->text($totalPrice->getAsString($length));
            $printer->text($cash->getAsString($length));
            $printer->text($change->getAsString($length));

            $printer->feed(2);

            $printer->setFont(Printer::FONT_A);


            /* Footer */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("This is not the official receipt\n");
            $printer->feed();
            $printer->text("-----------------------\n");
            $printer->text($date . "\n");

            $printer->feed(3);

            $printer->cut();

            /* Close printer */
            $printer->close();


        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }
}

class item
{
    private $name;
    private $description;
    private $quantity;
    private $note;

    public function __construct($name = '', $quantity = '', $description = '', $note = '')
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->note = $note;
    }

    public function getAsString($width = 48)
    {
        // $rightCols = 10;
        // $leftCols = $width - $rightCols;
        // if($this->description != '')
        // {
        //     $left = str_pad($this->name."\n   ".$this->description, $width);
        //     $rightCols *= 2;
        // }
        // else
        // {
        //     $left = str_pad($this->name , $leftCols);
        // }
        // $right = str_pad("X " . $this->quantity, $rightCols, ' ', STR_PAD_LEFT);
        // return "$left$right\n";
        $left = $this->quantity . " X  ".$this->name;
        if($this->description != '' || $this->description != null)
            $left .= $this->description;
        if($this->note != '' || $this->note != null)
            $left .= "\n note: ".$this->note;
        return "$left\n";
    }

    public function __toString()
    {
        return $this->getAsString();
    }
}

class receiptItem
{
    private $name;
    private $price;
    private $pesoSign;
    private $discount;

    public function __construct($name = '', $price = '', $discount = '', $pesoSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->pesoSign = $pesoSign;
        $this->discount = $discount;
    }

    public function getAsString($width = 30)
    {
        $rightCols = 10;
        $leftCols = $width - $rightCols;
        if ($this->pesoSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);
        $discount = '';

        $sign = ($this->pesoSign ? 'P ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);

        if($this->discount) {
            $discount = "\n".str_pad("(".$this->discount.")", $width/2, ' ', STR_PAD_LEFT);
        }

        return "$left$right$discount\n";
    }

    public function __toString()
    {
        return $this->getAsString();
    }
}
