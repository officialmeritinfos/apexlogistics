<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryStage;
use App\Models\Deposit;
use App\Models\FlightTicket;
use App\Models\GeneralSetting;
use App\Models\Guest;
use App\Models\Investment;
use App\Models\Package;
use App\Models\RealEstate;
use App\Models\ReturnType;
use App\Models\Service;
use App\Models\Withdrawal;
use App\Notifications\InvestmentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Home Page',
            'services'  =>Service::where('status',1)->get(),
        ];

        return view('home.home',$dataView);
    }

    public function about()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Company Overview',
        ];

        return view('home.about',$dataView);
    }
    public function terms()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Terms and Conditions',
        ];

        return view('home.terms',$dataView);
    }
    public function privacy()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Privacy Policy',
        ];

        return view('home.privacy',$dataView);
    }
    public function faqs()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Frequently Asked Questions',
        ];

        return view('home.faq',$dataView);
    }


    public function contact()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Contact us',
        ];

        return view('home.contact',$dataView);
    }

    public function tour()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Tour Services',
        ];

        return view('home.tour',$dataView);
    }
    public function travel()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Travel Agency Services',
        ];

        return view('home.travel',$dataView);
    }
    public function logistics()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Logistics Services',
        ];

        return view('home.logistics',$dataView);
    }
    public function visa()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Visa Preparation Services',
        ];

        return view('home.visa',$dataView);
    }
    public function flightTracking()
    {
        $web = GeneralSetting::where('id',1)->first();

        $dataView = [
            'siteName'  => $web->name,
            'web'       => $web,
            'pageName'  => 'Flight Tracking Services',
        ];

        return view('home.flight',$dataView);
    }
    //process package
    public function processPackage(Request  $request)
    {
        $request->validate([
            'tracking_id' => 'required|string|max:255',
        ]);

        $trackingId = $request->input('tracking_id');
        $package = Delivery::where('tracking_number', $trackingId)->first();

        if (!$package) {
            return redirect()->back()->with('error','Tracking ID not found. Please try again.');
        }

        return redirect(route('home.package.detail',['ref'=>$package->reference]))->with('success','Package found');
    }
    //package detail
    public function packageDetail($ref)
    {
        $package = Delivery::where('reference', $ref)->firstOrFail();

        $stages = DeliveryStage::where('delivery_id', $package->id)->orderBy('created_at', 'asc')->get();
        $web = GeneralSetting::find(1);

        return view('home.package_tracking_detail', compact('package', 'stages','web'));

    }
    //process flight
    public function processFLight(Request $request)
    {
        $request->validate([
            'pnr' => 'required|string|max:6|min:6',
        ]);

        $pnr = $request->input('pnr');
        $flight = FlightTicket::where('pnr', $pnr)->first();

        if (!$flight) {
            return redirect()->back()->with('error','PNR not found. Please try again.');
        }

        return redirect(route('home.flight.detail',['pnr'=>$flight->pnr]))->with('success','Flight found');
    }
    //flight detail
    public function flightDetail($pnr)
    {
        $flight = FlightTicket::where('pnr', $pnr)->firstOrFail();
        $web = GeneralSetting::find(1);

        return view('home.flight_tracking_detail', compact('flight','web'));

    }
}

