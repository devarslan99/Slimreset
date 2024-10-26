<?php
session_start();
// Check if the user is already logged in, redirect to dashboard if true
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>Slim Reset</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12 p-0">
                <a href="login.php" class="btn btn-primary" style="float:right;margin:15px;">Login</a>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div style="width:50%;">
                        <div>
                            <a class="logo" href="index.php">
                                <img class="img-fluid for-light" src="assets/images/logo/logo.png" alt="looginpage" style="width:200px;">
                                <img class="img-fluid for-dark" src="assets/images/logo/logo.png" alt="looginpage" style="width:200px;">
                            </a>
                        </div>
                        <div class="login-main">
                            <form id="onboardingform" method="post" class="theme-form" enctype="multipart/form-data">
                                <!-- Section 1 -->
                                <div id="section1" class="form-section">

                                    <?php
                                    if (isset($_GET['id'])) {
                                        echo '<input type="hidden" name="client_id" value="' . $_GET['id'] . '" readonly>';
                                    } else {
                                        echo '<input type="hidden" name="client_id" value="" readonly>';
                                    }
                                    ?>

                                    <h4 class="text-center">Let's Begin Your Medical Intake</h4>
                                    <p class="text-center">Please be as accurate as you can. If our medical practitioner
                                        has any questions we will follow up with you before prescribing.</p>
                                    <div class="form-group mb-0">
                                        <div class="text-end mt-3">
                                            <button class="btn btn-primary btn-block w-100" type="button" onclick="nextSection(2)">Get Started</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2 -->
                                <div id="section2" class="form-section" style="display:none;">
                                    <h4>Personal Information</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">What's your first name?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="first_name" placeholder="What's your first name?" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">What's your last name?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="last_name" placeholder="What's your last name?" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">the best email address for you?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="email_address" placeholder="the best email address for you?" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">the best number for us to text you?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="phone_number" placeholder="the best number for us to text you?" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">What's your birthdate?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="date" name="birth_date" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">What is your biological gender?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="gender" id="gender" required>
                                                    <option value="Male" selected>Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(3)">Next</button>
                                </div>

                                <!-- SECTION 3 -->
                                <div id="section3" class="form-section" style="display:none;">
                                    <h4>your medically prescribed products</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Please choose .your preferred administration
                                                option<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="injections_or_cream" id="injections_or_cream" required>
                                                    <option value="Injections" selected>Injections</option>
                                                    <option value="Compounded Cream">Compounded Cream</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(2)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(4)">Next</button>
                                </div>

                                <!-- SECTION 4 -->
                                <div id="section4" class="form-section" style="display:none;">
                                    <h4>what is the shipping address we can deliver to?</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Is this your home or a business?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <div class="form-check-size">
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline1" type="radio" name="address_type" value="Home" checked="">
                                                        <label class="form-check-label mb-0" for="radioinline1">Home</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline2" type="radio" name="address_type" value="Business">
                                                        <label class="form-check-label mb-0" for="radioinline2">Business</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Address<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="address" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Unit No?</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="unit_number" placeholder="Enter Value">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">City<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="city" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Province<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="province" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Postal Code<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="postal_code" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Any Delivery Notes?</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="delivery_notes" placeholder="Enter Value">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(3)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(5)">Next</button>
                                </div>

                                <!-- SECTION 5 -->
                                <div id="section5" class="form-section" style="display:none;">
                                    <h4>Weight Data</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">today's weight in lbs?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" name="today_weight" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">
                                                what's your goal weight in lbs?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="number" name="goal_weight" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">please confirm your height? (in feet and
                                                inches)<span style="color:red;">*</span></label>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="number" name="height_in_feet" placeholder="Enter Feet" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="number" name="height_in_inches" placeholder="Enter Inches" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Have You Always Struggled With Weight?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="struggled_with_weight" required>
                                                    <option value="" disabled>Please Choose</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">What are methods or programs you've tried before?
                                                <span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <div class="form-check-size">
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radio1" type="radio" name="methods_tried" value="Dr. Bernstein" checked="">
                                                        <label class="form-check-label mb-0" for="radio1">Dr.
                                                            Bernstein</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radio2" type="radio" name="methods_tried" value="Weight Watchers">
                                                        <label class="form-check-label mb-0" for="radio2">Weight
                                                            Watchers</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radio3" type="radio" name="methods_tried" value="Semaglutide">
                                                        <label class="form-check-label mb-0" for="radio3">Semaglutide</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radio4" type="radio" name="methods_tried" value="Another HCG Clinic">
                                                        <label class="form-check-label mb-0" for="radio4">Another HCG
                                                            Clinic</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radio5" type="radio" name="methods_tried" value="Personal Trainer">
                                                        <label class="form-check-label mb-0" for="radio5">Personal
                                                            Trainer</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radio6" type="radio" name="methods_tried" value="On my Own">
                                                        <label class="form-check-label mb-0" for="radio6">On my
                                                            Own</label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radio7" type="radio" name="methods_tried" value="Other">
                                                        <label class="form-check-label mb-0" for="radio7">Other</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">What has been your biggest struggle with weight
                                                loss?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="biggest_struggle_with_weight_loss" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Preffered Course Time?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="course_time" required>
                                                    <option value="" disabled>Please Choose</option>
                                                    <option value="60">60 Days</option>
                                                    <option value="30">30 Days</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(4)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(6)">Next</button>
                                </div>

                                <!-- SECTION 6 -->
                                <div id="section6" class="form-section" style="display:none;">
                                    <h4>are you taking any prescribed medication?</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Taking any prescribed medication?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="any_prescribed_medicine" name="any_prescribed_medicine" required>
                                                    <option value="" selected disabled>Please Choose</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="prescribed_medicines" style="display:none;">
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Medicine Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="prescribed_medicine_name" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Dosing Frequency?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="prescribed_medicine_frequency" required>
                                                        <option value="" disabled>Please Choose</option>
                                                        <option value="Daily">Daily</option>
                                                        <option value="Weekly">Weekly</option>
                                                        <option value="Monthly">Monthly</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">What is your dose?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="prescribed_medicine_dose" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Treatment Purpose?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="prescribed_medicine_treatment" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(5)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(7)">Next</button>
                                </div>

                                <!-- SECTION 7 -->
                                <div id="section7" class="form-section" style="display:none;">
                                    <h4>are you taking any over the counter medication?</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Taking any counter medication?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="any_counter_medicine" name="any_counter_medicine" required>
                                                    <option value="" selected disabled>Please Choose</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display:none;" id="counter_medicine">
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Medicine Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="counter_medicine_name" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Dosing Frequency?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="counter_medicine_frequency" required>
                                                        <option value="" disabled>Please Choose</option>
                                                        <option value="Daily">Daily</option>
                                                        <option value="Weekly">Weekly</option>
                                                        <option value="Monthly">Monthly</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">What is your dose?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="counter_medicine_dose" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Treatment Purpose?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="counter_medicine_treatment" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(6)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(8)">Next</button>
                                </div>

                                <!-- SECTION 8 -->
                                <div id="section8" class="form-section" style="display:none;">
                                    <h4>are you taking any supplements?</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Taking any supplement?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="any_supplement_medicine" name="any_supplement_medicine" required>
                                                    <option value="" selected disabled>Please Choose</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display:none;" id="supplement_medicine">
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Medicine Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="supplement_medicine_name" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Dosing Frequency?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="supplement_medicine_frequency" required>
                                                        <option value="" disabled>Please Choose</option>
                                                        <option value="Daily">Daily</option>
                                                        <option value="Weekly">Weekly</option>
                                                        <option value="Monthly">Monthly</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">What is your dose?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="supplement_medicine_dose" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Treatment Purpose?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="supplement_medicine_treatment" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(7)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(9)">Next</button>
                                </div>

                                <!-- SECTION 9 -->
                                <div id="section9" class="form-section" style="display:none;">
                                    <h4>product consumption?</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Do you smoke
                                                tobacco?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="smoke_tobacco-1" name="smoke_tobacco" required>
                                                    <option value="" selected>Please Choose</option>
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" id="how_many_packs_input" style="display: none;">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">How many packs per day?</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="how_many_packs" placeholder="Enter Value?">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Do you drink
                                                Alcohol?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="drink_alcohol" name="drink_alcohol" required>
                                                    <option value="" selected>Please Choose</option>
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" id="how_many_drinks" style="display: none;">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">How many drinks per week?</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="how_many_drinks" placeholder="Enter Value?">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Do You Have
                                                Caffeine?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="drink_coffee" name="have_caffeine" required>
                                                    <option value="" selected>Please Choose</option>
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" id="how_many_cups" style="display: none;">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">How Many Cups of coffee per day?</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="text" name="how_many_cups_of_coffee" placeholder="Enter Value?">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(8)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(10)">Next</button>
                                </div>

                                <!-- SECTION 10 -->
                                <div id="section10" class="form-section" style="display:none;">
                                    <h4>Have you had any of the following conditions? </h4>
                                    <hr />
                                    <!-- Condition 1: Heart Disease -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Heart Disease?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="0" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for heart disease -->
                                        <div class="row condition-inputs-0" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[0]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[0]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[0]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 2: High Blood Pressure -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">High Blood Pressure?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="1" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-1" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[1]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[1]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[1]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 3: Diabetes -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Diabetes?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="2" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-2" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[2]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[2]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[2]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 4: Arthritis -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Arthritis?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="3" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-3" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[3]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[3]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[3]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 5: Skin Disorder -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Skin Disorder?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="4" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-4" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[4]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[4]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[4]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 6: Skin Disorder -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Blood Clots?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="5" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-5" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[5]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[5]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[5]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 7: Cancer -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Cancer?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="6" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-6" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[6]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[6]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[6]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 8: Kidney Disease -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Kidney Disease?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="7" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-7" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[7]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[7]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[7]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 9: Liver Disease -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Liver Disease?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="8" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-8" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[8]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[8]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[8]">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Condition 10: Liver Disease -->
                                    <div class="col mb-3">
                                        <div class="row">
                                            <label class="col-sm-3">Gallbladder Disease?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control condition-dropdown" data-condition="9" required>
                                                    <option value="" disabled selected>Please Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                        <!-- Additional fields for high blood pressure -->
                                        <div class="row condition-inputs-9" style="display:none;">
                                            <div class="col-sm-5">
                                                <label>Has either one of your parents had this?</label>
                                                <input type="text" class="form-control" name="condition_1[9]">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Which parent?</label>
                                                <input type="text" class="form-control" name="condition_2[9]">
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Was this before age 65?</label>
                                                <input type="text" class="form-control" name="condition_3[9]">
                                            </div>
                                        </div>
                                    </div>


                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(9)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(11)">Next</button>
                                </div>

                                <!-- SECTION 11 -->
                                <div id="section11" class="form-section" style="display:none;">
                                    <h4>Past Medical Condition? </h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Any past conditions we haven't covered?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="past_condition_not_covered" name="past_condition_not_covered" required>
                                                    <option value="" selected disabled>Please Choose</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="past_condition" style="display:none;">
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">What was the condition?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="past_uncovered_condition" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Did you inherit from your mother or
                                                    father?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="past_condition_inherited">
                                                        <option value="" selected disabled>Please Choose</option>
                                                        <option value="Mother">Mother</option>
                                                        <option value="Father">Father</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Do you know what caused it?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="past_condition_cause" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">
                                                    How was it resolved?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="past_condition_solution" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(10)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(12)">Next</button>
                                </div>

                                <!-- SECTION 12 -->
                                <div id="section12" class="form-section" style="display:none;">
                                    <h4>any present medical conditions to share? </h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3">Any present conditions we haven't covered?<span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="present_condition_not_covered" name="present_condition_not_covered" required>
                                                    <option value="" selected disabled>Please Choose</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="present_condition" style="display:none;">
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">What is the condition?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="present_uncovered_condition" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Did you inherit from your mother or
                                                    father?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="present_condition_inherited">
                                                        <option value="" selected disabled>Please Choose</option>
                                                        <option value="Mother">Mother</option>
                                                        <option value="Father">Father</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">Do you know what caused it?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="present_condition_cause" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3">
                                                    How was it resolved?</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="present_condition_solution" placeholder="Enter Value" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(11)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(13)">Next</button>
                                </div>

                                <!-- SECTION 13 -->
                                <div id="section13" class="form-section" style="display:none;">
                                    <h4>Have you experienced any of the following symptoms?</h4>
                                    <hr />

                                    <div id="symptoms_container">
                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Abnormal Bleeding or Bruising?</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[0]" class="form-control symptom-dropdown" data-symptom="0" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-0" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[0]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[0]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[0]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Fever, Chills or Night Sweats?</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[1]" class="form-control symptom-dropdown" data-symptom="1" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-1" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[1]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[1]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[1]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Difficult or painful urination</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[2]" class="form-control symptom-dropdown" data-symptom="2" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-2" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[2]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[2]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[2]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Pain During Intercourse</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[3]" class="form-control symptom-dropdown" data-symptom="3" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-3" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[3]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[3]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[3]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Pain in the pelvic area?</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[4]" class="form-control symptom-dropdown" data-symptom="4" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-4" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[4]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[4]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[4]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">New growing lumps and bumps?</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[5]" class="form-control symptom-dropdown" data-symptom="5" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-5" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[5]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[5]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[5]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Low Bone Density?</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[6]" class="form-control symptom-dropdown" data-symptom="6" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-6" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[6]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[6]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[6]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3"> Electrolyte
                                                    abnormalities
                                                    like low or
                                                    high
                                                    Magnesium</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[7]" class="form-control symptom-dropdown" data-symptom="7" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-7" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[7]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[7]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[7]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="symptom-item mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Painful, red
                                                    joints especially
                                                    in the
                                                    big toes?</label>
                                                <div class="col-sm-9">
                                                    <select name="symptoms_value[8]" class="form-control symptom-dropdown" data-symptom="8" required>
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <!-- Additional fields -->
                                            <div class="row symptom-fields-8" style="display: none;">
                                                <div class="col-sm-3">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="doctor_aware[8]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>When Did this start?</label>
                                                    <input type="text" class="form-control" name="when_started[8]" placeholder="Date or time period">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="anything_done[8]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="women_symptoms_container" style="display:none;">
                                        <br />
                                        <h4>Women Only</h4>
                                        <hr />

                                        <!-- Symptom 1: Are you pregnant or trying to get pregnant? -->
                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Are you pregnant or trying to get
                                                    pregnant?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="0">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-0" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[0]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[0]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Symptom 2: Are you currently breastfeeding? -->
                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Are you currently breastfeeding?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="1">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-1" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[1]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[1]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Planning a Baby in the next year?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="2">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-2" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[2]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[2]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Have you ever had fibroids?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="3">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-3" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[3]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[3]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Breast mass, pain, rashes, or nipple
                                                    discharge?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="4">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-4" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[4]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[4]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Have you ever had ovarian cyst?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="5">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-5" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[5]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[5]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Post menopausal bleeding?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="6">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-6" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[6]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[6]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Bleeding or discharge not related to menstrual
                                                    periods?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="7">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-7" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[7]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[7]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col mb-3">
                                            <div class="row">
                                                <label class="col-sm-3">Date of last menstrual date?</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control women-symptom-dropdown" data-women-symptom="8">
                                                        <option value="" disabled selected>Please Choose</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="row women-symptom-fields-8" style="display:none;">
                                                <div class="col-sm-6">
                                                    <label>Doctor Aware?</label>
                                                    <input type="text" class="form-control" name="women_doctor_aware[8]" placeholder="Yes/No">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Has Anything Been Done?</label>
                                                    <input type="text" class="form-control" name="women_anything_done[8]" placeholder="Yes/No or Details">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <button class="btn btn-primary btn-block" type="button" onclick="prevSection(12)">Previous</button>
                                    <button class="btn btn-primary btn-block" type="button" onclick="nextSection(14)">Next</button>
                                </div>

                                <!-- SECTION 14 -->
                                <div id="section14" class="form-section" style="display:none;">
                                    <h4>program terms and acknowledgement</h4>
                                    <hr />
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="hormone_therapy" />
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Confirmation of Hormone Therapy:</h6>
                                                <hr />
                                                <p>
                                                    I understand my request for hCG, Vitamin B12 and program supplements
                                                    along with strict dietary restrictions outlined in the education
                                                    resources and materials provided by SlimReset</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="hormone_medication" />
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Hormone Prescription and Medication:</h6>
                                                <hr />
                                                <p>I understand that SlimReset's medical team can only prescribe hCG for
                                                    this treatment and all other health matters should be through my
                                                    regular physician(s).</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="primary_care" />
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Primary Care of my Physician:</h6>
                                                <hr />
                                                <p>SlimReset’s medical team can work in conjunction with, but cannot
                                                    replace, my regular primary care physicians such as general
                                                    practitioners or other specialists in family medicine or internal
                                                    medicine. Furthermore, I understand that I am not under the general
                                                    medical care of the SlimReset medical team.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Symptoms or Side Effects</h6>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="symptoms_acknowledge" />
                                            </div>
                                            <div class="col-sm-10">
                                                <p>I understand it's common for some clients to experience mild
                                                    headaches after day 3 related to your body detoxifying. It is not
                                                    the result of the hCG. The prescribed hCG is generally free of
                                                    negative side effects based on dose and natural composition.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="side_effect_acknowledge" />
                                            </div>
                                            <div class="col-sm-10">
                                                <p>I understand that side effects or complications are not expected,
                                                    however in the event that symptoms of concern occur while on my
                                                    journey I will inform my GP and the SlimReset practitioner team. If
                                                    symptoms are related to an emergency situation I understand that I
                                                    need to go to immediately to an emergency facility.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="medical_disclosure" />
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Disclosure of and Changes to my Medical History, Medical Conditions
                                                    or Disease:</h6>
                                                <hr />
                                                <p>I understand I must declare my entire medical history, medications or
                                                    disease and if there are any changes in my medical history,
                                                    medications or any other changes relevant to this program (life
                                                    events), I will advise my coach at that time. If I fail to disclose
                                                    any medical condition that I have, I release the medical staff and
                                                    everyone affiliated with SlimReset from any liability associated
                                                    with SlimReset and My Results.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="disclosure_failure" />
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Failure to Disclose Medical Conditions: </h6>
                                                <hr />
                                                <p>SlimReset reserves the right to deny a person access to the program
                                                    as deemed by the medical team or by the company. Failure to disclose
                                                    a condition or incompletely disclosing medicines, naturopathic
                                                    herbs, or supplements herein may result in program suspension and/or
                                                    program removal. SlimReset reserves the right to suspend or remove
                                                    you from the program with no refund or compensation payable for your
                                                    safety. By hereby checking this box, I fully understand the
                                                    importance of full and accurate disclosure of my medical history.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>
                                                    Acknowledge Compliance of SlimReset: </h6>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="compliance_1" />
                                            </div>
                                            <div class="col-sm-10">
                                                <p>I understand that my results on SlimReset are tied to my compliance
                                                    on program. I must report any problems that might occur immediately
                                                    to my coach to ensure my success.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="compliance_2" />
                                            </div>
                                            <div class="col-sm-10">
                                                <p>If a medical related problem occurs unrelated to the SlimReset
                                                    program I understand I must report this to my general practitioner
                                                    immediately. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="compliance_3" />
                                            </div>
                                            <div class="col-sm-10">
                                                <p>I acknowledge that compliance of the SlimReset program means
                                                    following the recommended dose of hormone and supplements, dietary
                                                    plan as guided by my coach and daily tracking in SlimReset's app of
                                                    my weight and dietary choices. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="compliance_4" />
                                            </div>
                                            <div class="col-sm-10">
                                                <p>I further understand that not complying could increase risks and
                                                    alter my results from the program</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="medical_no_fund" />
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Medical No Refund Policy: </h6>
                                                <hr />
                                                <p>I acknowledge that this medically assisted program and a prescription
                                                    medication and as such is NON-RETURNABLE and NON-REFUNDABLE.
                                                    SlimReset and it's medically licensed partners cannot accept the
                                                    return of prescription medications once it has been prescribed and
                                                    dispensed. Conditional Refunds ONLY applies if a contraindication is
                                                    identified by SlimReset's medical team on the patient’s medical
                                                    intake form prior to fulfilment and cannot join program.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 row">
                                            <div class="col-sm-2" style="display:flex;align-items:center;justify-content:center;">
                                                <input type="checkbox" name="signature_acknowledge" />
                                            </div>
                                            <div class="col-sm-10">
                                                <h6>Client Signature</h6>
                                                <hr />
                                                <p>
                                                    I acknowledge the above to be true and accurate.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <canvas id="signature-pad" width="400" height="200" style="border:1px solid #000;"></canvas>
                                        <br>
                                        <img id="signature-img-result" src="" style="display:none;" alt="Signature Preview" />

                                        <!-- Hidden input field to store Base64 signature -->
                                        <input type="hidden" id="signature-result" name="signature" value="">
                                    </div>
                                    <br />
                                    <br />
                                    <button id="clear" class="btn btn-secondary">Clear Signature</button>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
        <script src="assets/js/config.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

        <script>
            $(function() {
                var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    penColor: 'rgb(0, 0, 0)'
                });

                function getSignatureData() {
                    if (!signaturePad.isEmpty()) {
                        var imageData = signaturePad.toDataURL('image/png'); // Get image data as Base64
                        $('#signature-result').val(imageData); // Store Base64 image in hidden input
                    } else {
                        alert("Please provide a signature.");
                    }
                }

                $('#onboardingform').on('submit', function(e) {
                    getSignatureData(); // Capture the signature as Base64
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#onboardingform').submit(function(event) {
                    event.preventDefault();

                    // Show processing alert
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while your request is being processed',
                        icon: 'info',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    var formdata = new FormData(this);
                    $.ajax({
                        url: 'functions/register.php',
                        type: 'POST',
                        data: formdata,
                        contentType: false, // Required when sending FormData
                        processData: false, // Prevent jQuery from processing the FormData object
                        success: function(response) {
                            if (response.trim() === 'success') {
                                Swal.fire({
                                    title: 'Registration Successful',
                                    text: "An email has been sent to your provided email address.",
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "login.php";
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Registration Failed',
                                    text: "Please provide the essential details.",
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: "An error occurred while processing your request. Please try again.",
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            });
                        }
                    });
                });
            });
        </script>
        <script>
            // Function to validate the current section
            function validateSection(section) {
                const currentSection = document.getElementById('section' + section);
                const inputs = currentSection.querySelectorAll('input[required], select[required]');

                for (let input of inputs) {
                    if (!input.value) {
                        input.focus();
                        alert('Please Fill All Required Fields On This Step.');
                        return false;
                    }
                }
                return true;
            }

            // JavaScript to show the next section only if the current section is valid
            function nextSection(section) {
                const currentSection = section - 1; // Previous section number
                if (validateSection(currentSection)) {
                    document.querySelectorAll('.form-section').forEach(el => el.style.display = 'none');
                    document.getElementById('section' + section).style.display = 'block';
                }
            }

            // JavaScript to show the previous section
            function prevSection(section) {
                document.querySelectorAll('.form-section').forEach(el => el.style.display = 'none');
                document.getElementById('section' + section).style.display = 'block';
            }
        </script>
        <script>
            var gender = document.getElementById("gender");
            var women_symptoms_container = document.getElementById("women_symptoms_container");
            gender.addEventListener('change', function() {
                if (gender.value == "Female") {
                    women_symptoms_container.style.display = 'block';
                } else {
                    women_symptoms_container.style.display = 'none';
                }
            });
        </script>
        <script>
            var smoke_tobacco = document.getElementById("smoke_tobacco-1");
            var how_many_packs = document.getElementById("how_many_packs_input");
            smoke_tobacco.addEventListener('change', function() {
                if (smoke_tobacco.value == "Yes") {
                    how_many_packs.style.display = 'block';
                } else {
                    how_many_packs.style.display = 'none';
                }
            });


            var drink_alcohol = document.getElementById("drink_alcohol");
            var how_many_drinks = document.getElementById("how_many_drinks");
            drink_alcohol.addEventListener('change', function() {
                if (drink_alcohol.value == "Yes") {
                    how_many_drinks.style.display = 'block';
                } else {
                    how_many_drinks.style.display = 'none';
                }
            });

            var drink_coffee = document.getElementById("drink_coffee");
            var how_many_cups = document.getElementById("how_many_cups");
            drink_coffee.addEventListener('change', function() {
                if (drink_coffee.value == "Yes") {
                    how_many_cups.style.display = 'block';
                } else {
                    how_many_cups.style.display = 'none';
                }
            });


            var any_prescribed_medicine = document.getElementById("any_prescribed_medicine");
            var prescribed_medicine = document.getElementById("prescribed_medicines");

            // Function to toggle the visibility and required attributes
            any_prescribed_medicine.addEventListener('change', function() {
                if (any_prescribed_medicine.value == "Yes") {
                    // Show hidden fields
                    prescribed_medicine.style.display = 'block';

                    // Add 'required' attribute to all inputs within the prescribed_medicines section
                    document.querySelectorAll('#prescribed_medicines input, #prescribed_medicines select').forEach(function(input) {
                        input.setAttribute('required', 'required');
                    });
                } else if (any_prescribed_medicine.value == "No") {
                    // Hide the hidden fields
                    prescribed_medicine.style.display = 'none';

                    // Clear values of all inputs and remove 'required' attributes
                    document.querySelectorAll('#prescribed_medicines input, #prescribed_medicines select').forEach(function(input) {
                        input.value = ''; // Clear input values
                        input.removeAttribute('required'); // Remove the 'required' attribute
                    });
                }
            });

            var any_counter_medicine = document.getElementById("any_counter_medicine");
            var counter_medicine = document.getElementById("counter_medicine");

            // Function to toggle the visibility and required attributes
            any_counter_medicine.addEventListener('change', function() {
                if (any_counter_medicine.value == "Yes") {
                    // Show hidden fields
                    counter_medicine.style.display = 'block';

                    // Add 'required' attribute to all inputs within the counter_medicine section
                    document.querySelectorAll('#counter_medicine input, #counter_medicine select').forEach(function(input) {
                        input.setAttribute('required', 'required');
                    });
                } else if (any_counter_medicine.value == "No") {
                    // Hide the hidden fields
                    counter_medicine.style.display = 'none';

                    // Clear values of all inputs and remove 'required' attributes
                    document.querySelectorAll('#counter_medicine input, #counter_medicine select').forEach(function(input) {
                        input.value = ''; // Clear input values
                        input.removeAttribute('required'); // Remove the 'required' attribute
                    });
                }
            });


            var any_supplement_medicine = document.getElementById("any_supplement_medicine");
            var supplement_medicine = document.getElementById("supplement_medicine");

            // Function to toggle the visibility and required attributes
            any_supplement_medicine.addEventListener('change', function() {
                if (any_supplement_medicine.value == "Yes") {
                    // Show hidden fields
                    supplement_medicine.style.display = 'block';

                    // Add 'required' attribute to all inputs within the supplement_medicine section
                    document.querySelectorAll('#supplement_medicine input, #supplement_medicine select').forEach(function(input) {
                        input.setAttribute('required', 'required');
                    });
                } else if (any_supplement_medicine.value == "No") {
                    // Hide the hidden fields
                    supplement_medicine.style.display = 'none';

                    // Clear values of all inputs and remove 'required' attributes
                    document.querySelectorAll('#supplement_medicine input, #supplement_medicine select').forEach(function(input) {
                        input.value = ''; // Clear input values
                        input.removeAttribute('required'); // Remove the 'required' attribute
                    });
                }
            });

            var present_condition_not_covered = document.getElementById("present_condition_not_covered");
            var present_condition = document.getElementById("present_condition");

            // Function to toggle the visibility and required attributes
            present_condition_not_covered.addEventListener('change', function() {
                if (present_condition_not_covered.value == "Yes") {
                    // Show hidden fields
                    present_condition.style.display = 'block';

                    // Add 'required' attribute to all inputs within the present_condition section
                    document.querySelectorAll('#present_condition input, #present_condition select').forEach(function(input) {
                        input.setAttribute('required', 'required');
                    });
                } else if (present_condition_not_covered.value == "No") {
                    // Hide the hidden fields
                    present_condition.style.display = 'none';

                    // Clear values of all inputs and remove 'required' attributes
                    document.querySelectorAll('#present_condition input, #present_condition select').forEach(function(input) {
                        input.value = ''; // Clear input values
                        input.removeAttribute('required'); // Remove the 'required' attribute
                    });
                }
            });

            var past_condition_not_covered = document.getElementById("past_condition_not_covered");
            var past_condition = document.getElementById("past_condition");

            // Function to toggle the visibility and required attributes
            past_condition_not_covered.addEventListener('change', function() {
                if (past_condition_not_covered.value == "Yes") {
                    // Show hidden fields
                    past_condition.style.display = 'block';

                    // Add 'required' attribute to all inputs within the past_condition section
                    document.querySelectorAll('#past_condition input, #past_condition select').forEach(function(input) {
                        input.setAttribute('required', 'required');
                    });
                } else if (past_condition_not_covered.value == "No") {
                    // Hide the hidden fields
                    past_condition.style.display = 'none';

                    // Clear values of all inputs and remove 'required' attributes
                    document.querySelectorAll('#past_condition input, #past_condition select').forEach(function(input) {
                        input.value = ''; // Clear input values
                        input.removeAttribute('required'); // Remove the 'required' attribute
                    });
                }
            });
        </script>
        <script>
            document.querySelectorAll('.condition-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    var conditionId = this.getAttribute('data-condition');
                    var inputsDiv = document.querySelector('.condition-inputs-' + conditionId);

                    if (this.value === 'yes') {
                        inputsDiv.style.display = 'flex'; // Show the additional fields
                    } else {
                        inputsDiv.style.display = 'none'; // Hide the additional fields
                    }
                });
            });
        </script>
        <script>
            document.querySelectorAll('.symptom-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    let symptomIndex = this.getAttribute('data-symptom');
                    let symptomFields = document.querySelector('.symptom-fields-' + symptomIndex);

                    if (this.value === 'yes') {
                        symptomFields.style.display = 'flex'; // Use 'flex' for better alignment of the fields
                    } else {
                        symptomFields.style.display = 'none';
                    }
                });
            });
        </script>
        <script>
            document.querySelectorAll('.women-symptom-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    let symptomIndex = this.getAttribute('data-women-symptom');
                    let symptomFields = document.querySelector('.women-symptom-fields-' + symptomIndex);

                    if (this.value === 'yes') {
                        symptomFields.style.display = 'flex'; // Show the additional fields
                    } else {
                        symptomFields.style.display = 'none'; // Hide the additional fields
                    }
                });
            });
        </script>

    </div>
</body>

</html>