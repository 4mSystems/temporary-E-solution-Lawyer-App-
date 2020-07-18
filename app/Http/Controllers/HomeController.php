<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\Cases;
use App\mohdr;
use App\Sessions;
use Carbon\Carbon;
use App\Session_Notes;
use App\Package;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $package_id = auth()->user()->package_id;
        $user_package = Package::where('id',$package_id)->first();
        $id = getQuery();
        $admin = User::findOrFail($id);
        $admin->status = 'Deactive';
        $admin->save();
         $start_date = $admin->created_at;

         $end_date = $start_date->addMonths($user_package->duration)->addDays(7);

         $current_date = Carbon::now();
         if($current_date > $end_date){

             Auth::logout();
             return redirect('reservtion')->with('errors', ' تم انتهاء مده الاشتراك من فضلك قم بدفع قيمه الاشتراك !!');
         }


        $users = User::where('parent_id',getQuery())->get();
        $cases = Cases::where('parent_id',getQuery())->get();
        $sessions = Sessions::where('parent_id',getQuery())->get();
        $mohdreen = mohdr::where('parent_id',getQuery())->get();
        $today = Carbon::today();
        $date = Carbon::today()->addDays(10);


        $session = Sessions::whereBetween('session_date', array($today, $date))->where('parent_id',getQuery())->get();
        $sessionNo = Sessions::where('session_date', '<=', $today)->where('status', 'No')->where('parent_id',getQuery())->get();
        $datee = Carbon::today()->addDays(15);
        $mohder = mohdr::whereBetween('session_date', array($today, $datee))->where('parent_id',getQuery())->get();

        return view('home', compact(['users', 'cases', 'mohdreen', 'session', 'mohder', 'sessionNo','sessions']));

    }


    public function showMohData($id)
    {
        if (request()->ajax()) {
            $data = mohdr::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function showSessionNotes($id)
    {
        $session_notes = Session_Notes::where('session_Id', $id)->orderBy('id', 'desc')->get();
        $note_table = array();

        foreach ($session_notes as $note) {
            $note_table [] = view('cases.session_note_home_item', compact('note'))->render();
        }
        return response()->json(['result' => $note_table]);
    }


}
