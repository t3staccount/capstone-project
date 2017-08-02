<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class ReservationController extends Controller
{
    
    /* Reservation Status
    
        1 = Floating Reservation
        2 = Paid Reservation
        3 = Cancelled Reservation
        4 = Nasa resort na
        5 = Tapos na yung stay
    */
    
    //Book Reservation
    
    public function addReservation(Request $req){
        // Prepares data to be saved
        $tempCheckInDate = trim($req->input('s-CheckInDate'));
        $tempCheckOutDate = trim($req->input('s-CheckOutDate'));
        $tempPickUpTime = trim($req->input('s-PickUpTime'));
        $NoOfAdults = trim($req->input('s-NoOfAdults'));
        $NoOfKids = trim($req->input('s-NoOfKids'));
        $BoatsUsed = trim($req->input('s-BoatsUsed'));
        $ChosenRooms = trim($req->input('s-ChosenRooms'));
        $FirstName = trim($req->input('s-FirstName'));
        $MiddleName = trim($req->input('s-MiddleName'));
        $LastName = trim($req->input('s-LastName'));
        $Address = trim($req->input('s-Address'));
        $Email = trim($req->input('s-Email'));
        $Contact = trim($req->input('s-Contact'));
        $Nationality = trim($req->input('s-Nationality'));
        $tempDateOfBirth = trim($req->input('s-DateOfBirth'));

        $tempDateOfBirth2 = explode('/', $tempDateOfBirth);
        $tempCheckInDate2 = explode('/', $tempCheckInDate);
        $tempCheckOutDate2 = explode('/', $tempCheckOutDate);
        
        $Birthday = $tempDateOfBirth2[2] ."/". $tempDateOfBirth2[0] ."/". $tempDateOfBirth2[1];
        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1];
        $DateBooked = Carbon::now();
        $Gender;
        $Remarks;
        
        $CustomerID = DB::table('tblCustomer')->pluck('strCustomerID')->first();
        if(!$CustomerID){
           $CustomerID = "CUST1";
        }
        else{
           $CustomerID = $this->SmartCounter('tblCustomer', 'strCustomerID');
        }
        
        if(($req->input('s-Gender')) == "Male"){
            $Gender = "M";
        }
        else{
            $Gender = "F";
        }
        
        $tempTime = explode(' ',$tempPickUpTime);
        $PickUpTime = $tempTime[1];
        
        $tempPickUpTime2 = explode(':', $PickUpTime);
        
        $tempPickUpTime2[0] = ((int)$tempPickUpTime2[0]) + 1;
        
        $PickUpTime2 = $tempPickUpTime2[0].":".$tempPickUpTime2[1].":".$tempPickUpTime2[2];
        
        $ReservationID = DB::table('tblReservationDetail')->pluck('strReservationID')->first();
        if(!$ReservationID){
            $ReservationID = "RESV1";
        }
        else{
            $ReservationID = $this->SmartCounter('tblReservationDetail', 'strReservationID');
        }


        if(($req->input('s-Remarks')) == null){
            $Remarks = "N/A";
        }
        else{
            $Remarks = trim($req->input('s-Remarks'));
        }
        
        $endLoop = false;
        
        //Generate Random Reservation Code
        do{
            $ReservationCode = $this->RandomString();
            $DuplicateError = DB::table("tblReservationDetail")->where("strReservationCode", $ReservationCode)->pluck("strReservationCode")->first();
            if($DuplicateError == null){
                $endLoop = true;
            }
            else{
                $ReservationCode = $this->RandomString();
            }    
        }while($endLoop == false);
        
        //Saves Customer Data
        $CustomerData = array('strCustomerID'=>$CustomerID,
                          'strCustFirstName'=>$FirstName,
                          'strCustMiddleName'=>$MiddleName,
                          'strCustLastName'=>$LastName,
                          'strCustAddress'=>$Address,
                          'strCustContact'=>$Contact,
                          'strCustEmail'=>$Email,
                          'strCustNationality'=>$Nationality,
                          'strCustGender'=>$Gender,
                          'dtmCustBirthday'=>$Birthday,
                          'intCustomerConfirmed' => '0',
                          'intCustStatus' => '1');


        DB::table('tblCustomer')->insert($CustomerData);
        
        
        //Saves Reservation Data
        $ReservationData = array('strReservationID'=>$ReservationID,
                              'intWalkIn'=>'0',
                              'strResDCustomerID'=>$CustomerID,
                              'dtmResDArrival'=>$CheckInDate." ".$PickUpTime,
                              'dtmResDDeparture'=>$CheckOutDate." ".$PickUpTime,
                              'intResDNoOfAdults'=>$NoOfAdults,
                              'intResDNoOfKids'=>$NoOfKids,
                              'strResDRemarks'=>$Remarks,
                              'intResDStatus'=>'1',
                              'dteResDBooking'=>$DateBooked->toDateString(),
                              'strReservationCode'=>$ReservationCode);
        
        DB::table('tblReservationDetail')->insert($ReservationData);
        
        
        $this->saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID);
        
        //Save Reserved Boats
        if($BoatsUsed != null){
               $this->saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);          
        }

         \Session::flash('flash_message','Reservation successfully booked!');
         return redirect('/Reservations');
    }
    
    public function RandomString() {
        $length = 12;
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return $token;
    }
    
    public function SmartCounter($strTableName, $strColumnName){
        $endLoop = false;
        $latestID = DB::table($strTableName)->pluck($strColumnName)->first();
        
        $SmartCounter = $this->getID($latestID);
        
        do{
            $DuplicateError = DB::table($strTableName)->where($strColumnName, $SmartCounter)->pluck($strColumnName)->first();
            if($DuplicateError == null){
                $endLoop = true;
            }
            else{
                $SmartCounter = $this->getID($SmartCounter);
            }       
        }while($endLoop == false);
        
        return $SmartCounter;
    }
    
    public function getID($latestID){
        $arrTempID = str_split($latestID);

        $intArrSize = sizeof($arrTempID) - 1;
        $arrNumbers = Array();
        for($i = $intArrSize; $i > 0; $i--){
            if(is_numeric($arrTempID[$i])){
                array_push($arrNumbers, $arrTempID[$i]);
            }else{
                break;
            }
        }

        $arrRevNumbers = array_reverse($arrNumbers);
        $intCounter = implode($arrRevNumbers);
        $intCounterOLen = strlen($intCounter);
        $intCounter += 1;
        $intCounterNLen = strlen($intCounter);
        if($intCounterOLen > $intCounterNLen){
            $intZeroes = $intCounterOLen - $intCounterNLen;
            for($i = 0; $i < $intZeroes; $i++){
                $intCounter = "0" . $intCounter;
            }
        }
        
        array_splice($arrTempID, (sizeof($arrTempID) - sizeof($arrNumbers)), sizeof($arrNumbers));

        $strSmartCounter = implode($arrTempID) . $intCounter;
        
        return $strSmartCounter;
    }
    
    
    //Edit Reservation
    
    
    //Edit Reservation Info
    
    public function updateReservationInfo(Request $req){
        $ReservationID = trim($req->input('info-ReservationID'));
        $NoOfAdults = trim($req->input('NoOfAdults'));
        $NoOfKids = trim($req->input('NoOfKids'));
        $Remarks = trim($req->input('Remarks'));
        $BoatsUsed = trim($req->input('info-BoatsUsed'));
        $PickUpTime = trim($req->input('info-PickUpTime'));
        $CheckInDate = trim($req->input('info-CheckInDate'));
        $CheckOutDate = trim($req->input('info-CheckOutDate'));
        $updateData = array("intResDNoOfAdults" => $NoOfAdults, 
                     'intResDNoOfKids' => $NoOfKids,
                     'strResDRemarks' => $Remarks);   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);

        if($BoatsUsed != null){
            $tempPickUpTime2 = explode(':', $PickUpTime);
            $tempPickUpTime2[0] = ((int)$tempPickUpTime2[0]) + 1;
            $PickUpTime2 = $tempPickUpTime2[0].":".$tempPickUpTime2[1].":".$tempPickUpTime2[2];
                                                                                            
            DB::table('tblreservationboat')->where('strResBReservationID', '=', $ReservationID)->delete();
            DB::table('tblboatschedule')->where('strBoatSReservationID', '=', $ReservationID)->delete();
            $this->saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);
        }
        \Session::flash('flash_message','Reservation successfully updated!');
         return redirect('/Reservations');
    }
    
    //Edit Reservation Room
    
    public function updateReservationRoom(Request $req){
        $tempCheckInDate = trim($req->input('r-CheckInDate'));
        $tempCheckOutDate = trim($req->input('r-CheckOutDate'));
        $ChosenRooms = trim($req->input('ChosenRooms'));
        $ReservationID = trim($req->input('r-ReservationID'));
        $NoOfAdults = trim($req->input('r-NoOfAdults'));
        $NoOfKids = trim($req->input('r-NoOfKids'));
        $BoatsUsed = trim($req->input('r-BoatsUsed'));
        $PickUpTime = trim($req->input('r-PickUpTime'));
        
        DB::table('tblreservationroom')->where('strResRReservationID', '=', $ReservationID)->delete();
        $this->saveReservedRooms($ChosenRooms, $tempCheckInDate, $tempCheckOutDate, $ReservationID);
        
        if($NoOfKids != null && $NoOfKids != null){
            $updateData = array("intResDNoOfAdults" => $NoOfAdults, 
                     'intResDNoOfKids' => $NoOfKids);   
        
            DB::table('tblReservationDetail')
                ->where('strReservationID', $ReservationID)
                ->update($updateData);
        }
        
        if($BoatsUsed != null){
            $tempPickUpTime2 = explode(':', $PickUpTime);
            $tempPickUpTime2[0] = ((int)$tempPickUpTime2[0]) + 1;
            $PickUpTime2 = $tempPickUpTime2[0].":".$tempPickUpTime2[1].":".$tempPickUpTime2[2];
                                                                                            
            DB::table('tblreservationboat')->where('strResBReservationID', '=', $ReservationID)->delete();
            DB::table('tblboatschedule')->where('strBoatSReservationID', '=', $ReservationID)->delete();
            $this->saveReservedBoats($ReservationID, $tempCheckInDate, $tempCheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);
        }
        
        $CheckInDate = str_replace("/","-",$tempCheckInDate);
        $CheckOutDate = str_replace("/","-",$tempCheckOutDate);
        
        $tempArrivalDate = $CheckInDate ." ". $PickUpTime;
        $tempDepartureDate = $CheckOutDate ." ". $PickUpTime;
   
        $DateChecker = false;
        
        $OldReservationDates = DB::table('tblReservationDetail')
                                ->select('dtmResDArrival',
                                         'dtmResDDeparture')
                                ->where('strReservationID', $ReservationID)
                                ->get();

        foreach($OldReservationDates as $OldDate){
            if($OldDate->dtmResDArrival == $tempArrivalDate && $OldDate->dtmResDDeparture == $tempDepartureDate){
                $DateChecker = true;
            }
            else{
                $DateChecker = false;
            }
        }
        
        $arrCheckInDate = explode(' ', $tempArrivalDate);
        $arrCheckOutDate = explode(' ', $tempDepartureDate);
 
        $tempCheckInDate2 = explode('-', $arrCheckInDate[0]);
        $tempCheckOutDate2 = explode('-', $arrCheckOutDate[0]);

        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1] ." ". $arrCheckInDate[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1] ." ". $arrCheckOutDate[1];
        
        if(!$DateChecker){
            $updateDateData = array("dtmResDArrival" => $CheckInDate, 
                     'dtmResDDeparture' => $CheckOutDate);   
        
            DB::table('tblReservationDetail')
                ->where('strReservationID', $ReservationID)
                ->update($updateDateData);
            
            $ChosenBoats = DB::table('tblReservationBoat')->where('strResBReservationID', "=", $ReservationID)->pluck('strResBBoatID');
            if(count($ChosenBoats) != 0){
                DB::table('tblreservationboat')->where('strResBReservationID', '=', $ReservationID)->delete();
                DB::table('tblboatschedule')->where('strBoatSReservationID', '=', $ReservationID)->delete();
                $this->saveReservedBoats($ReservationID, $tempCheckInDate, $tempCheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed);
            }
            
        }
        
        \Session::flash('flash_message','Reservation successfully updated!');
        return redirect('/Reservations');
    }
    
    //Edit Reservation Date
    
    public function updateReservationDate(Request $req){
        $tempCheckInDate = trim($req->input('CheckInDate'));
        $tempCheckOutDate = trim($req->input('CheckOutDate'));
        $PickUpHour = trim($req->input('SelectHour'));
        $PickUpMinute = trim($req->input('SelectMinute'));
        $PickUpMerridean = trim($req->input('SelectMerridean'));
        $ReservationID = trim($req->input('d-ReservationID'));
   
        $tempCheckInDate2 = explode('/', $tempCheckInDate);
        $tempCheckOutDate2 = explode('/', $tempCheckOutDate);

        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1];
        
        $PickUpTime = "";
        
        if($PickUpMerridean == "PM"){
            $PickUpTime = ((int)$PickUpHour + 12) .":". $PickUpMinute .":00";
        }
        else{
            $PickUpTime = $PickUpHour .":". $PickUpMinute .":00";
        }
        
        $updateData = array("dtmResDArrival" => $CheckInDate." ".$PickUpTime, 
                     'dtmResDDeparture' => $CheckOutDate." ".$PickUpTime);   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        $ChosenBoats = DB::table('tblReservationBoat')->where('strResBReservationID', "=", $ReservationID)->pluck('strResBBoatID');
        if(count($ChosenBoats) != 0){
            $boatSchedData = array("dtmBoatSPickUp" => $CheckInDate." ".$PickUpTime, 
                                   'dtmBoatSDropoff' => $CheckOutDate." ".$PickUpTime); 
            
            DB::table('tblBoatSchedule')
            ->where([['strBoatSReservationID', $ReservationID],['strBoatSPurpose', 'Reservation']])
            ->update($boatSchedData);
        }
        
        \Session::flash('flash_message','Reservation successfully updated!');
         return redirect('/Reservations');
        
    }
    
    public function saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID){
        //Prepares Room Data
        $IndividualRooms = explode(',',$ChosenRooms);
        $IndividualRoomsLength = sizeof($IndividualRooms);
        $IndividualRoomType = [];
        
        for($x = 0; $x < $IndividualRoomsLength; $x++){
            $IndividualRoomDetails = explode('-', $IndividualRooms[$x]);
            $IndividualRoomType[$x] = DB::table('tblRoomType')->where([['strRoomType',"=",$IndividualRoomDetails[0]], ['intRoomTDeleted',"=","1"]])->pluck('strRoomTypeID')->first();
        }
        
        $AvailableRooms = "";
        $IndividualRoomTypeLength = sizeof($IndividualRoomType);
         
        for($x = 0; $x < $IndividualRoomTypeLength; $x++){

            $Rooms = DB::select("SELECT a.strRoomID FROM tblRoom a, tblRoomType b, tblRoomRate c WHERE strRoomID NOT IN(SELECT strResRRoomID FROM tblReservationRoom WHERE strResRReservationID IN(SELECT strReservationID FROM tblReservationDetail WHERE (intResDStatus = 1 OR intResDStatus = 2) AND ((dtmResDDeparture BETWEEN '".$CheckInDate."' AND '".$CheckOutDate."') OR (dtmResDArrival BETWEEN '".$CheckInDate."' AND '".$CheckOutDate."') AND NOT intResDStatus = 3))) AND a.strRoomTypeID = b.strRoomTypeID AND a.strRoomTypeID = c.strRoomTypeID AND a.strRoomStatus = 'Available' AND c.dtmRoomRateAsOf = (SELECT MAX(dtmRoomRateAsOf) FROM tblRoomRate WHERE strRoomTypeID = a.strRoomTypeID) AND a.strRoomTypeID = '".$IndividualRoomType[$x]."'");
            
            
            foreach($Rooms as $Room){
                $AvailableRooms .= $Room->strRoomID . ",";
            }
            
            $AvailableRooms .= "@";
        }
        
        $arrAvailableRooms = explode('@', $AvailableRooms);
        array_pop($arrAvailableRooms);

  
       
        //Saves Reserved Rooms
        for($x = 0; $x < $IndividualRoomTypeLength; $x++){
           $IndividualRoomsInfo = explode('-', $IndividualRooms[$x]);

           for($y = 0; $y < $IndividualRoomsInfo[3]; $y++){
               $AvailableRoomsArray = explode(',', $arrAvailableRooms[$x]);
               array_pop($AvailableRoomsArray);
               $AvailableRoomsArrayLength = sizeof($AvailableRoomsArray);

                   for($z = 0; $z <= $AvailableRoomsArrayLength; $z++){
                        if($z != $IndividualRoomsInfo[3]){
                            $InsertRoomsData = array('strResRReservationID'=>$ReservationID,
                                                     'strResRRoomID'=>$AvailableRoomsArray[$z]);
                            DB::table('tblReservationRoom')->insert($InsertRoomsData);
                        }
                        else{
                            break;
                        }
                    }
                break;

           }
        }
    }
    
    
    //Cancel Reservation
    
    public function cancelReservation(Request $req){
        $ReservationID = trim($req->input('CancelReservationID'));
        
        $updateData = array("intResDStatus" => "3");   
        
        DB::table('tblReservationDetail')
            ->where('strReservationID', $ReservationID)
            ->update($updateData);
        
        $ChosenBoats = DB::table('tblReservationBoat')->where('strResBReservationID', "=", $ReservationID)->pluck('strResBBoatID');
        if(count($ChosenBoats) != 0){
            $updateBoatData = array("intBoatSStatus" => "0");
            DB::table('tblBoatSchedule')
                ->where('strBoatSReservationID', $ReservationID)
                ->update($updateBoatData);
        }
        
        \Session::flash('flash_message','Reservation successfully cancelled!');
         return redirect('/Reservations');
    }
    
    //MISC
    public function saveReservedBoats($ReservationID, $CheckInDate, $CheckOutDate, $PickUpTime, $PickUpTime2, $BoatsUsed){
        $IndividualBoats = explode(",",$BoatsUsed);
        array_pop($IndividualBoats);
        $IndividualBoatsLength = sizeof($IndividualBoats);

        for($x = 0; $x < $IndividualBoatsLength; $x++){
            $temp = "";
            $BoatID = DB::table('tblBoat as a')
                             ->join ('tblBoatRate as b', 'a.strBoatID', '=' , 'b.strBoatID')
                                ->select('a.strBoatID')
                                ->whereNotIn('a.strBoatID', [DB::raw("(SELECT strBoatSBoatID FROM tblBoatSchedule WHERE (date(dtmBoatSPickUp) = '".$CheckInDate."') AND '".$PickUpTime."' BETWEEN time(dtmBoatSPickUp) AND time(DATE_ADD(dtmBoatSPickUp, INTERVAL 1 HOUR)))")])
                                ->where([['a.strBoatStatus', "=", 'Available'], ['b.dtmBoatRateAsOf',"=", DB::raw("(SELECT max(dtmBoatRateAsOf) FROM tblBoatRate WHERE strBoatID = a.strBoatID)")], ['a.strBoatName', '=', $IndividualBoats[$x]]])
                                ->orderBy('a.intBoatCapacity')
                                ->get();

            foreach($BoatID as $Boat){
                $temp = $Boat->strBoatID;
            }

            $InsertBoatData = array('strResBReservationID'=>$ReservationID,
                                    'strResBBoatID'=>$temp);

            DB::table('tblReservationBoat')->insert($InsertBoatData);

            $BoatSchedID = DB::table('tblBoatSchedule')->pluck('strBoatScheduleID')->first();
            if(!$BoatSchedID){
                $BoatSchedID = "BSCHD1";
            }
            else{
                $BoatSchedID = $this->SmartCounter('tblBoatSchedule', 'strBoatScheduleID');
            }

            $InsertBoatSchedData = array('strBoatScheduleID'=>$BoatSchedID,
                                         'strBoatSBoatID'=>$temp,
                                         'strBoatSPurpose'=>'Reservation',
                                         'dtmBoatSPickUp'=>$CheckInDate." ".$PickUpTime,
                                         'dtmBoatSDropOff'=>$CheckInDate." ".$PickUpTime2,
                                         'intBoatSStatus'=>'1',
                                         'strBoatSReservationID' => $ReservationID);

            DB::table('tblBoatSchedule')->insert($InsertBoatSchedData);  

        }   
    }
    
    
    
    
    /*----------------- WALK IN -------------------*/
    
    public function addWalkIn(Request $req){
        // Prepares data to be saved
        $tempCheckInDate = trim($req->input('s-CheckInDate'));
        $tempCheckOutDate = trim($req->input('s-CheckOutDate'));
        $NoOfAdults = trim($req->input('s-NoOfAdults'));
        $NoOfKids = trim($req->input('s-NoOfKids'));
        $ChosenRooms = trim($req->input('s-ChosenRooms'));
        $FirstName = trim($req->input('s-FirstName'));
        $MiddleName = trim($req->input('s-MiddleName'));
        $LastName = trim($req->input('s-LastName'));
        $Address = trim($req->input('s-Address'));
        $Email = trim($req->input('s-Email'));
        $Contact = trim($req->input('s-Contact'));
        $Nationality = trim($req->input('s-Nationality'));
        $tempDateOfBirth = trim($req->input('s-DateOfBirth'));

        $tempDateOfBirth2 = explode('/', $tempDateOfBirth);
        $tempCheckInDate2 = explode('/', $tempCheckInDate);
        $tempCheckOutDate2 = explode('/', $tempCheckOutDate);
        
        $Birthday = $tempDateOfBirth2[2] ."/". $tempDateOfBirth2[0] ."/". $tempDateOfBirth2[1];
        $CheckInDate = $tempCheckInDate2[2] ."/". $tempCheckInDate2[0] ."/". $tempCheckInDate2[1];
        $CheckOutDate = $tempCheckOutDate2[2] ."/". $tempCheckOutDate2[0] ."/". $tempCheckOutDate2[1];
        $DateBooked = Carbon::now();
        $Gender;
        $Remarks;
        
        $CustomerID = DB::table('tblCustomer')->pluck('strCustomerID')->first();
        if(!$CustomerID){
           $CustomerID = "CUST1";
        }
        else{
           $CustomerID = $this->SmartCounter('tblCustomer', 'strCustomerID');
        }
        
        if(($req->input('s-Gender')) == "Male"){
            $Gender = "M";
        }
        else{
            $Gender = "F";
        }
        
        $dt = Carbon::now('HongKong');
        $TimeToday = $dt->toTimeString();          
        
        $PickUpTime = "";
        $arrTimeToday = explode(':', $TimeToday);
        if(((int)$arrTimeToday[1] >= 00) && ((int)$arrTimeToday[1]<=15)){
            $PickUpTime = $arrTimeToday[0] .":00:00"; 
        }
        else if(((int)$arrTimeToday[1] >= 15) && ((int)$arrTimeToday[1]<=30)){
            $PickUpTime = $arrTimeToday[0] .":15:00";
        }
        else if(((int)$arrTimeToday[1] >= 30) && ((int)$arrTimeToday[1]<=45)){
            $PickUpTime = $arrTimeToday[0] .":30:00";
        }
        else{
            $PickUpTime = $arrTimeToday[0] .":45:00";
        }
        
        
        $ReservationID = DB::table('tblReservationDetail')->pluck('strReservationID')->first();
        if(!$ReservationID){
            $ReservationID = "RESV1";
        }
        else{
            $ReservationID = $this->SmartCounter('tblReservationDetail', 'strReservationID');
        }


        if(($req->input('s-Remarks')) == null){
            $Remarks = "N/A";
        }
        else{
            $Remarks = trim($req->input('s-Remarks'));
        }
        
        $endLoop = false;
        
         //Saves Customer Data
        $CustomerData = array('strCustomerID'=>$CustomerID,
                          'strCustFirstName'=>$FirstName,
                          'strCustMiddleName'=>$MiddleName,
                          'strCustLastName'=>$LastName,
                          'strCustAddress'=>$Address,
                          'strCustContact'=>$Contact,
                          'strCustEmail'=>$Email,
                          'strCustNationality'=>$Nationality,
                          'strCustGender'=>$Gender,
                          'dtmCustBirthday'=>$Birthday,
                          'intCustomerConfirmed' => '1',
                          'intCustStatus' => '1');


        DB::table('tblCustomer')->insert($CustomerData);
        
        
        //Saves Reservation Data
        $ReservationData = array('strReservationID'=>$ReservationID,
                              'intWalkIn'=>'1',
                              'strResDCustomerID'=>$CustomerID,
                              'dtmResDArrival'=>$CheckInDate." ".$PickUpTime,
                              'dtmResDDeparture'=>$CheckOutDate." ".$PickUpTime,
                              'intResDNoOfAdults'=>$NoOfAdults,
                              'intResDNoOfKids'=>$NoOfKids,
                              'strResDRemarks'=>$Remarks,
                              'intResDStatus'=>'4',
                              'dteResDBooking'=>$DateBooked->toDateString(),
                              'strReservationCode'=>null);
        
        DB::table('tblReservationDetail')->insert($ReservationData);   
        
        $this->saveReservedRooms($ChosenRooms, $CheckInDate, $CheckOutDate, $ReservationID);

        \Session::flash('flash_message','Booked successfully!');
        \Session::flash('ReservationID', $ReservationID);
        return redirect('/ChooseRooms/'.$ReservationID);
    }
    
    public function saveChosenRooms(Request $req){
        $ReservationID = trim($req->input('s-ReservationID'));
        $ChosenRooms = json_decode(trim($req->input('s-ChosenRooms')));
        
        $tempArrRooms = "";
        foreach($ChosenRooms as $Rooms){
            $temp = (int)count($Rooms->ChosenRooms);
            for($x = 0; $x < $temp; $x++){
                $tempArrRooms .= DB::table('tblRoom')->where([['strRoomStatus', 'Available'],['strRoomName', $Rooms->ChosenRooms[$x]]])->orderBy('strRoomID')->pluck('strRoomID');
                $tempArrRooms .= ",";
            }
        }
        
        $arrChosenRooms = explode(",", $tempArrRooms);
        array_pop($arrChosenRooms);
        for($x = 0; $x < count($arrChosenRooms); $x++){
            $arrChosenRooms[$x] = str_replace('"', '', $arrChosenRooms[$x]);
            $arrChosenRooms[$x] = str_replace('[', '', $arrChosenRooms[$x]);
            $arrChosenRooms[$x] = str_replace(']', '', $arrChosenRooms[$x]);
        }
        
        DB::table('tblReservationRoom')->where('strResRReservationID', '=', $ReservationID)->delete();
        
        for($x = 0; $x < count($arrChosenRooms); $x++){
            $data = array('strResRReservationID'=>$ReservationID,
                     'strResRRoomID'=>$arrChosenRooms[$x]);
        
            DB::table('tblReservationRoom')->insert($data);
        }
        
        \Session::flash('flash_message','Saved successfully!');
         return redirect('/Rooms');
    }
    

}
