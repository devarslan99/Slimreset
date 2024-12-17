<style>
    /* Container Box */
    .intolerance-container-box {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 20px 0;
        padding: 10px 0;
    }

    /* High Section */
    .intolerance-high-info-section {
        flex: 0 0 20%;
        padding-left: 15px;
        text-align: left;
        border-right: 1px solid #ddd;
    }

    .intolerance-high-info-section .intolerance-high-title {
        font-size: 1.5rem;
        color: #e74c3c;
        font-weight: bold;
        text-transform: capitalize;
    }

    .intolerance-high-info-section p {
        color: #888;
        font-size: 0.9rem;
    }

    /* Medium Section */
    .intolerance-medium-info-section {
        flex: 0 0 20%;
        padding-left: 15px;
        text-align: left;
        border-right: 1px solid #ddd;
    }

    .intolerance-medium-info-section .intolerance-medium-title {
        font-size: 1.5rem;
        color: #f39c12;
        font-weight: bold;
        text-transform: capitalize;
    }

    .intolerance-medium-info-section p {
        color: #888;
        font-size: 0.9rem;
    }

    /* Content Section */
    .intolerance-content-section {
        flex: 1;
        padding: 10px 20px;
    }

    /* Content Item */
    .intolerance-content-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    /* Icons */
    .intolerance-high-icon {
        color: #e74c3c;
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .intolerance-medium-icon {
        color: #f39c12;
        margin-right: 10px;
        font-size: 1.2rem;
    }

    /* Progress Bar */
    .intolerance-content-item .intolerance-progress-container {
        flex: 1;
        position: relative;
    }

    .intolerance-content-item .intolerance-progress {
        height: 8px;
        background-color: #f8f8f8;
        border-radius: 5px;
        overflow: hidden;
    }

    .intolerance-content-item .intolerance-progress .intolerance-progress-bar {
        height: 8px;
    }

    /* Value Text */
    .intolerance-content-item .intolerance-value {
        font-size: 0.9rem;
        margin-left: 10px;
        color: #555;
    }

    .intolerance-value-green {
        color: #27ae60;
    }
</style>
<div class="container my-5">
    <!-- High Section -->
    <div class="intolerance-container-box">
        <!-- Info Section -->
        <div class="intolerance-high-info-section">
            <span class="intolerance-high-icon fs-1"><i class="fa fa-warning"></i></span>
            <div class="intolerance-high-title">High</div>
            <p>These foods have been indicated as inflammatory.</p>
        </div>
        <!-- Content Section -->
        <div class="intolerance-content-section">
            <!-- Item 1 -->
            <div class="intolerance-content-item">
                <span class="intolerance-high-icon"><i class="fa fa-warning"></i></span>
                <span>Tomatoes</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar bg-danger" style="width: 50%;"></div>
                        <div class="intolerance-progress-bar bg-success" style="width: 50%;"></div>
                    </div>
                </div>
                <span class="intolerance-value">9001100</span>
            </div>
            <!-- Item 2 -->
            <div class="intolerance-content-item">
                <span class="intolerance-high-icon"><i class="fa fa-warning"></i></span>
                <span>Resistant Starch</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar bg-danger" style="width: 60%;"></div>
                        <div class="intolerance-progress-bar bg-success" style="width: 40%;"></div>
                    </div>
                </div>
                <span class="intolerance-value">2528.13 rpkm</span>
            </div>
            <!-- Item 3 -->
            <div class="intolerance-content-item">
                <span class="intolerance-high-icon"><i class="fa fa-warning"></i></span>
                <span>Tomatoes</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar bg-warning" style="width: 40%;"></div>
                        <div class="intolerance-progress-bar bg-success" style="width: 60%;"></div>
                    </div>
                </div>
                <span class="intolerance-value intolerance-value-green">922.70 rpkm</span>
            </div>
        </div>
    </div>

    <!-- Medium Section -->
    <div class="intolerance-container-box">
        <!-- Info Section -->
        <div class="intolerance-medium-info-section">
            <span class="intolerance-medium-icon fs-1"><i class="fa fa-warning"></i></span>
            <div class="intolerance-medium-title">Medium</div>
            <p>These foods have been indicated as inflammatory.</p>
        </div>
        <!-- Content Section -->
        <div class="intolerance-content-section">
            <!-- Item 1 -->
            <div class="intolerance-content-item">
                <span class="intolerance-medium-icon"><i class="fa fa-warning"></i></span>
                <span>Zucchini</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar bg-danger" style="width: 50%;"></div>
                        <div class="intolerance-progress-bar bg-success" style="width: 50%;"></div>
                    </div>
                </div>
                <span class="intolerance-value">9001100</span>
            </div>
            <!-- Item 2 -->
            <div class="intolerance-content-item">
                <span class="intolerance-medium-icon"><i class="fa fa-warning"></i></span>
                <span>Tomatoes</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar bg-danger" style="width: 60%;"></div>
                        <div class="intolerance-progress-bar bg-success" style="width: 40%;"></div>
                    </div>
                </div>
                <span class="intolerance-value">2528.13 rpkm</span>
            </div>
            <!-- Item 3 -->
            <div class="intolerance-content-item">
                <span class="intolerance-medium-icon"><i class="fa fa-warning"></i></span>
                <span>Tomatoes</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar bg-warning" style="width: 40%;"></div>
                        <div class="intolerance-progress-bar bg-success" style="width: 60%;"></div>
                    </div>
                </div>
                <span class="intolerance-value intolerance-value-green">922.70 rpkm</span>
            </div>
        </div>
    </div>
</div>
