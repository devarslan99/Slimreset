<style>


/* Main Wrapper */
.coach_ui_wrapper {
    display: flex;
    width: 100%;
    min-height: 100vh;
}

/* Left Section */
.coach_left_section {
    width: 70%;
    padding: 40px;
}

.coach_tabs {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
}

.coach_tab {
    color: black;
    text-transform: lowercase;
    font-weight: bold;
    cursor: pointer;
    font-size: 14px;
    padding-bottom: 5px;
    border-bottom: 2px solid transparent;
}

.coach_tab.active {
    color: #936CFB;
    border-bottom-color: #936CFB;
}

/* Coaching Content */
.coach_content_wrapper {
    margin-top: 20px;
}

.coach_content {
    display: none;
}

.coach_content.active {
    display: block;
}

.coach_heading {
    font-weight: bold;
    font-size: 24px;
    margin-bottom: 20px;
    text-transform: lowercase;
    text-align: center;
    margin: 40px 0;
}

/* List */
.coach_list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.coach_list_item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 25px;
    background-color: #f3f3f3;
    border-radius: 50px;
    color: #555;
    font-weight: 500;
    cursor: pointer;
}

.coach_list_item.active {
    background-color: #936CFB;
    color: #ffffff;
}

.play_icon, .check_icon {
    font-weight: bold;
    margin-right: 10px;
}

.check_icon {
    display: none;
}

.check_icon.active {
    display: block;
    border: 1px solid #fff;
    width: 25px;
    border-radius: 50%;
    height: 25px;
    text-align: center;
    line-height: 25px;
}

/* Videos Section */
.coach_video_section, .coach_faq_section {
    font-size: 16px;
    color: #555;
}

.coach_video_list {
    list-style-type: disc;
    margin-left: 20px;
}

/* Right Section */
.coach_right_section {
    width: 30%;
    padding: 40px;
    text-align: center;
    border-left: 1px solid #ddd;
}

.coach_corner_title {
    font-size: 18px;
    font-weight: bold;
    color: #000;
}

/* Responsive Design */
@media (max-width: 768px) {
    .coach_ui_wrapper {
        flex-direction: column;
    }

    .coach_left_section, .coach_right_section {
        width: 100%;
        border-left: none;
    }

    .coach_tabs {
        justify-content: center;
    }
}

</style>
 <!-- Main Container -->
 <div class="coach_ui_wrapper">
        <!-- Left Section -->
        <div class="coach_left_section">
            <!-- Custom Tabs -->
            <div class="coach_tabs">
                <div class="coach_tab active" data-target="coach_content_journey">my journey</div>
                <div class="coach_tab" data-target="coach_content_videos">videos</div>
                <div class="coach_tab" data-target="coach_content_faqs">faq's</div>
            </div>

            <!-- Tab Content -->
            <div class="coach_content_wrapper">
                <!-- My Journey -->
                <div id="coach_content_journey" class="coach_content active">
                    <h2 class="coach_heading">coaching</h2>
                    <div class="coach_list">
                        <div class="coach_list_item active">
                            <div>
                                <span class="play_icon">▶</span>
                                <span> welcome</span>
                            </div>
                            <span class="check_icon active">✔</span>
                        </div>
                        <div class="coach_list_item">
                            <div>
                                <span class="play_icon">▶</span> 
                                <span>why do we gain weight?</span>
                            </div>
                            <span class="check_icon">✔</span>
                        </div>
                        <div class="coach_list_item">
                            <div>
                                <span class="play_icon">▶</span> 
                                <span>why do we gain weight?</span>
                            </div>
                            <span class="check_icon">✔</span>
                        </div>
                        <div class="coach_list_item">
                            <div>
                                <span class="play_icon">▶</span> 
                                <span>why do we gain weight?</span>
                            </div>
                            <span class="check_icon">✔</span>  
                        </div>
                    </div>
                </div>

                <!-- Videos Section -->
                <div id="coach_content_videos" class="coach_content">
                    <h2 class="coach_heading">videos</h2>
                    <div class="coach_video_section">
                        <p>Here you will find videos related to your journey.</p>
                        <ul class="coach_video_list">
                            <li>Introduction to coaching</li>
                            <li>Understanding weight gain</li>
                            <li>Steps to healthy living</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQs Section -->
                <div id="coach_content_faqs" class="coach_content">
                    <h2 class="coach_heading">faq's</h2>
                    <div class="coach_faq_section">
                        <p><strong>Q:</strong> Why do we gain weight?</p>
                        <p><strong>A:</strong> Weight gain occurs when calorie intake exceeds expenditure over time.</p>
                        <p><strong>Q:</strong> How can I start losing weight?</p>
                        <p><strong>A:</strong> Start by improving your diet and incorporating regular physical activity.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="coach_right_section">
            <h3 class="coach_corner_title">coach’s corner</h3>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll('.coach_tab');
            const contents = document.querySelectorAll('.coach_content');
            const listItems = document.querySelectorAll('.coach_list_item');

            // Tab Switching Logic
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');

                    // Remove active states
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));

                    // Activate the clicked tab and corresponding content
                    this.classList.add('active');
                    document.getElementById(target).classList.add('active');
                });
            });

            // Coaching List Active State and Check Icon Logic
            listItems.forEach(item => {
                item.addEventListener('click', function () {
                    // Remove active state from all items and check icons
                    listItems.forEach(el => {
                        el.classList.remove('active');
                        el.querySelector('.check_icon').classList.remove('active');
                    });

                    // Add active state to the clicked item and its check icon
                    this.classList.add('active');
                    this.querySelector('.check_icon').classList.add('active');
                });
            });
        });
    </script>