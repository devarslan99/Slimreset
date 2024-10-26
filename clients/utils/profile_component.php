<div class="row">
    <?php

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $user_id = $_GET['id'];
        $sql = "SELECT users.*, medical_intake.* FROM users INNER JOIN medical_intake ON users.id = medical_intake.user_id WHERE users.id = $user_id";

        $result = mysqli_query($mysqli, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Personal Information</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">What is your first name?
                            <b><?php echo $row['first_name'] ?></b>
                        </p>
                        <p class="mt-2">What is your last name?
                            <b><?php echo $row['last_name'] ?></b>
                        </p>
                        <p class="mt-2">the best email address for
                            you?
                            <b><?php echo $row['email'] ?></b>
                        </p>
                        <p class="mt-2">the best number for us to
                            text you?
                            <b><?php echo $row['contact_no'] ?></b>
                        </p>
                        <p class="mt-2">Birth Date?
                            <b><?php echo $row['birth_date'] ?></b>
                        </p>
                        <p class="mt-2">Gender?
                            <b><?php echo $row['gender'] ?></b>
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>your medically prescribed products</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">preferred administration
                            option?
                            <b><?php echo $row['injections_or_cream'] ?></b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>what is the shipping address we can
                            deliver to?</h4>
                    </div>
                    <div class="card-body">
                        <p class="mt-2">Is this your home or a
                            business?
                            <b><?php echo $row['address_type'] ?></b>
                        </p>
                        <p class="mt-2">Address?
                            <b><?php echo $row['address'] ?></b>
                        </p>
                        <p class="mt-2">Unit No?
                            <b><?php echo $row['unit_number'] ?></b>
                        </p>
                        <p class="mt-2">City?
                            <b><?php echo $row['city'] ?></b>
                        </p>
                        <p class="mt-2">Province?
                            <b><?php echo $row['province'] ?></b>
                        </p>
                        <p class="mt-2">Postal Code?
                            <b><?php echo $row['postal_code'] ?></b>
                        </p>
                        <p class="mt-2">Delivery Notes?
                            <b><?php echo $row['delivery_notes'] ?></b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Weight Data</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">Today's Weight? <b>
                                <b><?php echo isset($row['today_weight']) && !empty($row['today_weight']) ? $row['today_weight'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <p class="mt-2">Goal Weight?
                            <b><?php echo isset($row['goal_weight']) && !empty($row['goal_weight']) ? $row['goal_weight'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <p class="mt-2">Height? (Feet and Inches)
                            <b><?php echo isset($row['height']) && !empty($row['height']) ? $row['height'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <p class="mt-2">Is weight something you've
                            struggled with your whole life?
                            <b><?php echo isset($row['struggled_with_weight']) && !empty($row['struggled_with_weight']) ? $row['struggled_with_weight'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <p class="mt-2">What are methods you've
                            tried before?
                            <b><?php echo isset($row['methods_tried']) && !empty($row['methods_tried']) ? $row['methods_tried'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <p class="mt-2">
                            What has been your biggest struggle with
                            weight loss?
                            <b><?php echo isset($row['biggest_struggle_with_weight_loss']) && !empty($row['biggest_struggle_with_weight_loss']) ? $row['biggest_struggle_with_weight_loss'] : 'N/A'; ?></b>
                            </b>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>are you taking any prescribed
                            medication?</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">are you taking any
                            prescribed medication?
                            <b>
                                <b><?php echo isset($row['any_prescribed_medicine']) && !empty($row['any_prescribed_medicine']) ? $row['any_prescribed_medicine'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['any_prescribed_medicine'] == "Yes") {
                            ?>
                            <p class="mt-2">medication name?
                                <b><?php echo isset($row['prescribed_medicine_name']) && !empty($row['prescribed_medicine_name']) ? $row['prescribed_medicine_name'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">dosing frequency?
                                <b><?php echo isset($row['prescribed_medicine_frequency']) && !empty($row['prescribed_medicine_frequency']) ? $row['prescribed_medicine_frequency'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">what is your dose?
                                <b><?php echo isset($row['prescribed_medicine_dose']) && !empty($row['prescribed_medicine_dose']) ? $row['prescribed_medicine_dose'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">treatment purpose?
                                <b><?php echo isset($row['prescribed_medicine_treatment']) && !empty($row['prescribed_medicine_treatment']) ? $row['prescribed_medicine_treatment'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>are you taking any over the counter
                            medication?</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">are you taking any over the
                            counter medication?
                            <b>
                                <b><?php echo isset($row['any_counter_medicine']) && !empty($row['any_counter_medicine']) ? $row['any_counter_medicine'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['any_counter_medicine'] == "Yes") {
                            ?>
                            <p class="mt-2">medication name?
                                <b><?php echo isset($row['counter_medicine_name']) && !empty($row['counter_medicine_name']) ? $row['counter_medicine_name'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">dosing frequency?
                                <b><?php echo isset($row['counter_medicine_frequency']) && !empty($row['counter_medicine_frequency']) ? $row['counter_medicine_frequency'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">what is your dose?
                                <b><?php echo isset($row['counter_medicine_dose']) && !empty($row['counter_medicine_dose']) ? $row['counter_medicine_dose'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">treatment purpose?
                                <b><?php echo isset($row['counter_medicine_treatment']) && !empty($row['counter_medicine_treatment']) ? $row['counter_medicine_treatment'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>are you taking any supplements?</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">are you taking any
                            supplements?
                            <b>
                                <b><?php echo isset($row['any_supplement_medicine']) && !empty($row['any_supplement_medicine']) ? $row['any_supplement_medicine'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['any_supplement_medicine'] == "Yes") {
                            ?>
                            <p class="mt-2">medication name?
                                <b><?php echo isset($row['supplement_medicine_name']) && !empty($row['supplement_medicine_name']) ? $row['supplement_medicine_name'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">dosing frequency?
                                <b><?php echo isset($row['supplement_medicine_frequency']) && !empty($row['supplement_medicine_frequency']) ? $row['supplement_medicine_frequency'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">what is your dose?
                                <b><?php echo isset($row['supplement_medicine_dose']) && !empty($row['supplement_medicine_dose']) ? $row['supplement_medicine_dose'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">treatment purpose?
                                <b><?php echo isset($row['supplement_medicine_treatment']) && !empty($row['supplement_medicine_treatment']) ? $row['supplement_medicine_treatment'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Consumption</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">Do you smoke tobacco?
                            <b>
                                <b><?php echo isset($row['smoke_tobacco']) && !empty($row['smoke_tobacco']) ? $row['smoke_tobacco'] : 'N'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['smoke_tobacco'] == "Yes") {
                            ?>
                            <p class="mt-2">How many packs in a day?
                                <b><?php echo isset($row['how_many_packs']) && !empty($row['how_many_packs']) ? $row['how_many_packs'] : 'N/A'; ?></b>
                                </b>
                                <?php
                        }
                        ?>
                        </p>
                        <p class="mt-2">Do you drink alcohol?
                            <b><?php echo isset($row['drink_alcohol']) && !empty($row['drink_alcohol']) ? $row['drink_alcohol'] : 'N'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['drink_alcohol'] == "Yes") {
                            ?>
                            <p class="mt-2">How many drinks per week?
                                <b><?php echo isset($row['how_many_drinks']) && !empty($row['how_many_drinks']) ? $row['how_many_drinks'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <?php
                        }
                        ?>
                        <p class="mt-2">Do you have caffeine?
                            <b><?php echo isset($row['have_caffeine']) && !empty($row['have_caffeine']) ? $row['have_caffeine'] : 'N'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['have_caffeine'] == "Yes") {
                            ?>
                            <p class="mt-2">How many cups of coffee per
                                day?
                                <b><?php echo isset($row['how_many_cups_of_coffee']) && !empty($row['how_many_cups_of_coffee']) ? $row['how_many_cups_of_coffee'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>past medical conditions</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">Any past conditions we
                            haven't covered?
                            <b>
                                <b><?php echo isset($row['past_condition_not_covered']) && !empty($row['past_condition_not_covered']) ? $row['past_condition_not_covered'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['past_condition_not_covered'] == "Yes") {
                            ?>
                            <p class="mt-2">What was the condition?
                                <b><?php echo isset($row['past_uncovered_condition']) && !empty($row['past_uncovered_condition']) ? $row['past_uncovered_condition'] : 'N/A'; ?></b>
                                </b>
                            </p>

                            <p class="mt-2">
                                Did you inherit from your mother or
                                father?
                                <b><?php echo isset($row['past_condition_inherited']) && !empty($row['past_condition_inherited']) ? $row['past_condition_inherited'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">
                                Do you know what caused it?
                                <b><?php echo isset($row['past_condition_cause']) && !empty($row['past_condition_cause']) ? $row['past_condition_cause'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">
                                How was it resolved?
                                <b><?php echo isset($row['past_condition_solution']) && !empty($row['past_condition_solution']) ? $row['past_condition_solution'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>present medical conditions</h4>
                    </div>
                    <div class="card-body">

                        <p class="mt-2">any present medical
                            conditions to share?
                            <b>
                                <b><?php echo isset($row['present_condition_not_covered']) && !empty($row['present_condition_not_covered']) ? $row['present_condition_not_covered'] : 'N/A'; ?></b>
                            </b>
                        </p>
                        <?php
                        if ($row['present_condition_not_covered'] == "Yes") {
                            ?>
                            <p class="mt-2">What was the condition?
                                <b><?php echo isset($row['present_uncovered_condition']) && !empty($row['present_uncovered_condition']) ? $row['present_uncovered_condition'] : 'N/A'; ?></b>
                                </b>
                            </p>

                            <p class="mt-2">
                                Did you inherit from your mother or
                                father?
                                <b><?php echo isset($row['present_condition_inherited']) && !empty($row['present_condition_inherited']) ? $row['present_condition_inherited'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">
                                Do you know what caused it?
                                <b><?php echo isset($row['present_condition_cause']) && !empty($row['present_condition_cause']) ? $row['present_condition_cause'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <p class="mt-2">
                                How was it resolved?
                                <b><?php echo isset($row['present_condition_solution']) && !empty($row['present_condition_solution']) ? $row['present_condition_solution'] : 'N/A'; ?></b>
                                </b>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Signature</h4>
                    </div>
                    <div class="card-body">
                        <img src="<?php echo $row['signature'] ?>">
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>