<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Reservation</title>
    @include('layouts.links')
    
    <script src="/js/input-validator.js" type="text/javascript"></script>
    <script src="/js/BookReservation.js" type="text/javascript"></script>
</head>

<body class="profile-page">
    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- End Navbar -->
    <div class="wrapper">
        <div class="page-header page-header-small" filter-color="orange">
            <div class="page-header-image" data-parallax="true" style="background-image: url('/img/header-1.jpeg');">
            </div>
            <div class="container">
                <div class="content-center brand">
                    <h1 class="h1-seo">Il Sogno</h1>
                    <h3>Perfect Budget Getaway</h3>
                </div>
            </div>
        </div>
        <div class="section section-tabs">
            <div class="container">
                <h3 class="title">Book Reservation with Packages</h3>
                <h5 class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus non nisi sed purus accumsan dictum. Ut eget velit velit. Etiam rhoncus ut mauris vel congue.</h5>
                <!-- End .section-navbars  -->
                <div class="section section-tabs">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Tabs with Background on Card -->
                                <div class="card">
                                    <ul class="nav nav-tabs nav-tabs-neutral justify-content-center text-center" role="tablist" data-background-color="orange">
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link active" data-toggle="tab" id="DateList">
                                                <i class="fa fa-calendar-o"></i> Date
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link" data-toggle="tab" id="RoomList">
                                                <i class="fa fa-bed"></i> Rooms
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link" data-toggle="tab" id="InfoList">
                                                <i class="fa fa-user-o"></i> Guest
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link inactive-link" data-toggle="tab" id="BillList">
                                                <i class="fa fa-money"></i> Bill
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="card-block">
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            
                                            <div class="tab-pane active" id="ReservationDate" role="tabpanel">
                                                <h6 class="title text-center">Reservation Dates</h6><br>
                                                
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="alert alert-danger" role="alert" style="display: none">
                                                            <div class="container">
                                                                <div class="alert-icon">
                                                                    <i class="fa fa-info"></i>
                                                                </div>
                                                                <p id="ErrorMessage" class="description-text">aaaaaa</p>
                                                                <button type="button" class="close" onclick="HideAlert()">
                                                                    <span aria-hidden="true">
                                                                        <i class="fa fa-remove"></i>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <button class="btn btn-primary pull-right" onclick="CheckInput()">Check Available Rooms</button>
                                                <br><br>
                                            </div>
                                            
                                            
                                            <div class="tab-pane" id="ReservationRoom" role="tabpanel">
                                                <h6 class="title text-center">Please select your desired packages</h6><br>
                                                <div class="row">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-10">
                                                        <p class="text-muted text-center">Packages Available</p>
                                                        <div class="row">
                                                          <div class="table">
                                                                <table class="text-center stretch-element" id="tblAvailableRooms" onclick="run(event, 'AvailableRooms')">
                                                                    <thead class="text-primary">
                                                                        <th class="text-center">Package Name</th>
                                                                        <th class="text-center">Package Duration</th>
                                                                        <th class="text-center">Pax</th>
                                                                        <th class="text-center">Package Rate</th>
                                                                        <th class="text-center">Description</th>
                                                                        <th class="text-center">Action</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Name</td>
                                                                            <td>Duration</td>
                                                                            <td>Pax</td>
                                                                            <td>Rate</td>
                                                                            <td>Description</td>
                                                                            <td><span data-toggle="tooltip" data-placement="top" title="Show Package Inclusions"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Name</td>
                                                                            <td>Duration</td>
                                                                            <td>Pax</td>
                                                                            <td>Rate</td>
                                                                            <td>Description</td>
                                                                            <td><span data-toggle="tooltip" data-placement="top" title="Show Package Inclusions"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Name</td>
                                                                            <td>Duration</td>
                                                                            <td>Pax</td>
                                                                            <td>Rate</td>
                                                                            <td>Description</td>
                                                                            <td><span data-toggle="tooltip" data-placement="top" title="Show Package Inclusions"><button class="btn btn-neutral remove-padding" data-toggle="modal" data-target="#" value="" onclick=""><i class="fa fa-arrows-alt text-primary cursor-pointer"></i></button></span></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <br><br>
                                                            </div>         
                                                        </div>
                                                        <p class="text-muted text-center">Please note that the availability of the packages will be based on the given reservation dates.</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="alert alert-danger" role="alert" style="display: none">
                                                            <div class="container">
                                                                <div class="alert-icon">
                                                                    <i class="fa fa-info"></i>
                                                                </div>
                                                                <p id="RoomErrorMessage" class="description-text">aaaaaa</p>
                                                                <button type="button" class="close" onclick="HideAlert()">
                                                                    <span aria-hidden="true">
                                                                        <i class="fa fa-remove"></i>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <button class="btn btn-primary pull-left" onclick="GoBack('#ReservationRoom','#ReservationDate','#RoomList','#DateList')">Change Date/Time</button>
                                                <button class="btn btn-primary pull-right" onclick="CheckRooms()">Continue</button>
                                                <br><br>
                                            </div>
                                            
                                            
                                            <div class="tab-pane" id="ReservationInfo" role="tabpanel">
                                                <h6 class="title text-center">Guest Information</h6><br>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="small-margin">First Name</label>
                                                        <div class="form-group" id="FirstNameError">
                                                            <input type="text" value="" class="form-control" onkeyup="CheckInfoInput(this, 'string2', '#FirstNameError')" onchange="CheckInfoInput(this, 'string2', '#FirstNameError')" id="FirstName"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="small-margin">Middle Name</label>
                                                        <div class="form-group" id="MiddleNameError">
                                                            <input type="text" value="" class="form-control" onkeyup="CheckInfoInput(this, 'string2', '#MiddleNameError')" onchange="CheckInfoInput(this, 'string2', '#MiddleNameError')" id="MiddleName"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="small-margin">Last Name</label>
                                                        <div class="form-group" id="LastNameError">
                                                            <input type="text" value="" class="form-control" onkeyup="CheckInfoInput(this, 'string2', '#LastNameError')" onchange="CheckInfoInput(this, 'string2', '#LastNameError')" id="LastName"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small-margin">Address</label>
                                                        <div class="form-group">
                                                            <input type="text" value="" class="form-control" id="Address"/>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="small-margin">Contact Number</label>
                                                        <div class="form-group" id="ContactError">
                                                            <input type="text" value="" class="form-control" onkeyup="CheckInfoInput(this, 'int2', '#ContactError')" onchange="CheckInfoInput(this, 'int2', '#ContactError')" id="ContactNumber"/>
                                                        </div>    
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="small-margin">Email</label>
                                                        <div class="form-group" id="EmailError">
                                                            <input type="email" value="" class="form-control" onkeyup="CheckInfoInput(this, 'email', '#EmailError')" onchange="CheckInfoInput(this, 'email', '#EmailError')" id="Email"/>
                                                        </div>    
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="small-margin">Nationality</label>
                                                        <div class="form-group" id="NationalityError">
                                                            <input type="text" value="" class="form-control" onkeyup="CheckInfoInput(this, 'string2', '#NationalityError')" onchange="CheckInfoInput(this, 'string2', '#NationalityError')" id="Nationality"/>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Gender</label>
                                                        <div class="selectBox">
                                                            <select id="SelectGender">
                                                              <option>Male</option>
                                                              <option>Female</option>               
                                                            </select>
                                                        </div>   
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="small-margin">Date of Birth</label>
                                                        <input type="text" class="form-control date-picker" data-datepicker-color="" id="DateOfBirth">   
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <label class="small-margin">Remarks</label>
                                                    <textarea class="form-control" rows="5" id=Remarks></textarea>
                                                    </div>
                                                </div>
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="alert alert-danger" role="alert" style="display: none">
                                                            <div class="container">
                                                                <div class="alert-icon">
                                                                    <i class="fa fa-info"></i>
                                                                </div>
                                                                <p id="InfoErrorMessage" class="description-text">aaaaaa</p>
                                                                <button type="button" class="close" onclick="HideAlert()">
                                                                    <span aria-hidden="true">
                                                                        <i class="fa fa-remove"></i>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <button class="btn btn-primary pull-left" onclick="GoBack('#ReservationInfo','#ReservationRoom', '#InfoList', '#RoomList')">Back</button>
                                                <button class="btn btn-primary pull-right" onclick="CheckReservationInfo()">Continue</button>
                                                <br><br>
                                            </div>
                                            
                                            
                                            <div class="tab-pane" id="ReservationBill" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="text-center text-primary title">Reservation Summary</h5>
                                                        <div class="table">
                                                            <h6 class="text-center text-muted title">Accomodation</h6>
                                                            <div style="margin-left: 20px">
                                                                <p class="description-text text-primary small-margin">Check In Date:</p> <p class="description-text" id="i-CheckInDate">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Check Out Date:</p> <p class="description-text" id='i-CheckOutDate'>aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Arrival Time:</p> <p class="description-text" id='i-ArrivalTime'>aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Number of Adult Guests:</p> <p class="description-text" id='i-NoOfAdults'>aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Number of Children Guests:</p> <p class="description-text" id='i-NoOfKids'>aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Remarks:</p> <p class="description-text" id='i-Remarks'>aaa</p><br>
                                                            </div>
                                                            <h6 class="text-center text-muted title">Guest Information</h6>
                                                            <div style="margin-left:20px">
                                                                <p class="description-text text-primary small-margin">Name:</p> <p class="description-text" id="i-GuestName">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Address:</p> <p class="description-text" id="i-Address">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Contact Number:</p> <p class="description-text" id='i-ContactNumber'>aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Email:</p> <p class="description-text" id='i-Email'>aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Nationality:</p> <p class="description-text" id="i-Nationality">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Gender:</p> <p class="description-text" id="i-Gender">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Date of Birth:</p> <p class="description-text" id="i-DateOfBirth">aaa</p><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 class="text-center text-primary title">Initial Bill</h5>
                                                        <div class="table">
                                                            <h6 class="text-center text-muted title">Accomodation Fee</h6>
                                                            <div style="margin-left: 20px">
                                                                <div class="row">
                                                                    <table class="text-center stretch-element" id="tblBill">
                                                                        <thead class="text-primary">
                                                                            <th class="text-center">Room</th>
                                                                            <th class="text-center">Quantity</th>
                                                                            <th class="text-center">Rate per day</th>
                                                                            <th class="text-center">Price</th>
                                                                        </thead>
                                                                        <tbody>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <br><br>
                                                                <p class="description-text text-primary small-margin">Total Room Fee:</p> <p class="description-text" id="b-TotalRoomFee">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Total days of stay:</p> <p class="description-text" id="b-DaysOfStay">aaa</p><br><br>
                                                                <strong><p class="description-text text-primary small-margin">Total Accomodation Fee:</p> <p class="description-text" id="TotalAccomodationFee">aaa</p></strong><br><br>
                                                            </div>
                                                            <h6 class="text-center text-muted title">Miscellaneous Fee</h6>
                                                            <div style="margin-left: 20px">
                                                                <p class="description-text text-primary small-margin">Total Adult Guests:</p> <p class="description-text" id="b-TotalAdults">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Entrance Fee:</p> <p class="description-text" id="EntranceFee">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Total Entrance Fee:</p> <p class="description-text" id="TotalEntranceFee">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Boat(s) Used:</p> <p class="description-text" id="BoatsUsed">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Transportation Fee:</p> <p class="description-text" id="TransportationFee">aaa</p><br><br>
                                                                <strong><p class="description-text text-primary small-margin">Total Miscellaneous Fee:</p> <p class="description-text" id="TotalMiscellaneousFee">aaa</p></strong><br><br>
                                                            </div>
                                                            <h6 class="text-center text-muted title">Grand Total</h6>
                                                            <div style="margin-left: 20px">
                                                                <p class="description-text text-primary small-margin">Accomodation Fee:</p> <p class="description-text" id="AccomodationFee" id="AccomodationFee">aaa</p><br>
                                                                <p class="description-text text-primary small-margin">Total Miscellaneous Fee:</p> <p class="description-text" id=MiscellaneousFee>aaa</p><br><br>
                                                                <h5 class="description-text text-primary small-margin">Total Initial Fee:</h5> <h5 class="description-text" id="GrandTotal">aaa</h5><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="text-center text-primary title">Notice</h5>
                                                        <p class="description-margin"><i class="fa fa-check-circle text-primary"></i> Minimum  of 20% of the total initial bill must be paid at the accredited banks as a down payment. </p>
                                                        <p class="description-margin"><i class="fa fa-check-circle text-primary"></i> Cancellation of reservation can be done anytime through the use of this website or by calling the resort, but there are no refunds.</p>
                                                        <p class="description-margin"><i class="fa fa-check-circle text-primary"></i> The reservation must be a week or more from today.</p>
                                                        <p class="description-margin"><i class="fa fa-check-circle text-primary"></i> Rescheduling of the reservation can be done using this website or by calling us.</p>
                                                        <p class="description-margin"><i class="fa fa-check-circle text-primary"></i> Customers who reserved a boat are given 30 minutes of time allowance during the actual time of arrival to accommodate their reservations. Else, the reserved boats will be available for other guests use.</p>
                                                        <p class="description-margin"><i class="fa fa-check-circle text-primary"></i> If you have more questions, you can always <a href="/ContactUs" class="text-primary" target="_blank">contact us</a>.</p>
                                                        <p class="description-margin"><i class="fa fa-check-circle text-primary"></i>Accredited Bank(s):</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 text-center">
                                                        <button class="btn btn-primary" onclick="GoBack('#ReservationBill', '#ReservationInfo', '#BillList', 'InfoList')">Make Changes</button>
                                                    </div>
                                                    <div class="col-md-8 text-center">
                                                        <button class="btn btn-primary btn-lg">BOOK RESERVATION</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tabs on plain Card -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Section Tabs -->
     
            </div>
        </div>
        @include('layouts.footer')
    </div>
    
    <!--Room Modal-->
    <div class="modal fade" id="ModalRoomInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="position: absolute; width: 500px">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="RoomTypeName"></h4>
          </div>
          <div class="modal-body">
             <div class="text-center">
                <img src="/img/Rooms/Room1.jpg" alt="Raised Image" class="rounded img-raised med-image"><br> 
             </div>
             <label class="text-primary">Room Category:</label> <p class="description-text" id="RoomCategory"></p><br>
             <label class="text-primary">Room Rate:</label> <p class="description-text" id="RoomRate"></p><br>
             <label class="text-primary">Room Capacity:</label> <p class="description-text" id="RoomCapacity"></p><br>
             <label class="text-primary">Number of Beds:</label> <p class="description-text" id=NoOfBeds></p><br>
             <label class="text-primary">Number of Bathrooms:</label> <p class="description-text" id="NoOfBathrooms"></p><br>
             <label class="text-primary">Aircondition:</label> <p class="description-text" id="RoomAircondition"></p><br>
             <label class="text-primary">Room Description:</label> <p class="description-text" id="RoomDescription"></p><br>
          </div>
        </div>
      </div>
    </div>
    
    <!--Boat Modal-->
    <div class="modal fade" id="ModalAvailBoat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                    <h5 class="modal-title text-center">Would you like to avail a boat to get to the resort?</h5>
                  </div>
              </div>
              <br>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" id="BtnAvailBoat">Yes</button>
                <button type="button" class="btn btn-primary btn-simple small-margin" id="BtnAvailNoBoat">No</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- No Available Boats -->
    <div class="modal fade" id="ModalNoBoats" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                    <h5 class="modal-title text-center">There are no available boats based on the given date and time</h5>
                  </div>
              </div>
              <br>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" id="BtnWithoutBoats1">Continue without reserving a boat</button>
              </div>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" data-dismiss="modal">Change Date/Time</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Avail Multiple Boats -->
    <div class="modal fade" id="ModalMultipleBoats" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                    <h5 class="modal-title text-center">There are no boats that can accomodate the total number of guests, would you like to avail multiple boats?</h5>
                  </div>
              </div>
              <br>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" id="BtnWithoutBoats2">Continue without reserving a boat</button>
              </div>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" data-dismiss="modal">Change Date/Time</button>
              </div>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" id="BtnMultipleBoats">Avail Multiple Boats</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- No Multiple Boats -->
    <div class="modal fade" id="ModalNoMultipleBoats" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                    <h5 class="modal-title text-center">There are still no boats that can accomodate the total number of guests</h5>
                  </div>
              </div>
              <br>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" id="BtnWithoutBoats3">Continue without reserving a boat</button>
              </div>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-simple small-margin" data-dismiss="modal">Change Date/Time</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    
    
</body>


</html>