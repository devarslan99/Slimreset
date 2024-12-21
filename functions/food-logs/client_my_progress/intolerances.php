<style>
    /* Container Box */
    .intolerance-container-box {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 10px;
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
        justify-content: space-between;
        margin-bottom: 20px;
        border-bottom: 1px solid #dddddd;
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

    .title-icon {
        min-width: 150px;
    }

    /* Progress Bar */
    .intolerance-content-item .intolerance-progress-container {
        position: relative;
        width: 200px;
    }

    .intolerance-content-item .intolerance-progress {
        height: 8px;
        background-color: #f8f8f8;
        border-radius: 5px;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .intolerance-content-item .intolerance-progress .intolerance-progress-bar {
        height: 8px;
    }

    .status-high {
        background-color: #ff999a;
    }

    .status-medium {
        background-color: #fabe7d;
    }

    .status-success {
        background-color: #9ae3c0;
    }

    /* Value Text */
    .intolerance-content-item .intolerance-value {
        font-size: 0.9rem;
        color: #555;
    }

    .intolerance-value-green {
        color: #27ae60;
    }
</style>

<style>
    @media (max-width: 900px) {
        .intolerance-container-box {
            flex-wrap: wrap;
        }

        .intolerance-high-info-section,
        .intolerance-medium-info-section {
            flex: 1 0 100%;
            padding-bottom: 15px;
            border-right: none;
            border-bottom: 1px solid #ddd;
        }

        .intolerance-content-section {
            flex: 1 0 100%;
            padding-top: 10px;
        }

        .intolerance-content-item {
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .title-icon {
            flex: 1 0 100%;
            margin-bottom: 10px;
        }

        .intolerance-progress-container {
            width: 100%;
            max-width: 100%;
        }

        .intolerance-content-item span {
            font-size: 0.85rem;
        }

        .intolerance-high-icon,
        .intolerance-medium-icon {
            font-size: 1rem;
        }
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
                <div class="title-icon">
                    <span class="intolerance-high-icon"><i class="fa fa-warning"></i></span>
                    <span>Tomatoes</span>
                </div>
                <div>
                    <span class="intolerance-value">9001100</span>
                </div>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar status-high" style="width: 30%;"></div>
                        <div class="intolerance-progress-bar status-medium" style="width: 20%;"></div>
                        <div class="intolerance-progress-bar status-success" style="width: 50%;"></div>
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="intolerance-content-item">
                <div class="title-icon">
                    <span class="intolerance-high-icon"><i class="fa fa-warning"></i></span>
                    <span>Resistant Starch</span>
                </div>
                <div>
                    <span class="intolerance-value">2528.13 rpkm</span>
                </div>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar status-high" style="width: 60%;"></div>
                        <div class="intolerance-progress-bar status-success" style="width: 40%;"></div>
                    </div>
                </div>
            </div>
            <!-- Item 3 -->
            <div class="intolerance-content-item">
                <div class="title-icon">
                    <span class="intolerance-high-icon"><i class="fa fa-warning"></i></span>
                    <span>Tomatoes</span>
                </div>
                    <span class="intolerance-value intolerance-value-green">922.70 rpkm</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar status-medium" style="width: 40%;"></div>
                        <div class="intolerance-progress-bar status-success" style="width: 60%;"></div>
                    </div>
                </div>
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
                <div class="title-icon">
                    <span class="intolerance-medium-icon"><i class="fa fa-warning"></i></span>
                    <span>Zucchini</span>
                </div>
                <span class="intolerance-value">9001100</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar status-high" style="width: 50%;"></div>
                        <div class="intolerance-progress-bar status-success" style="width: 50%;"></div>
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="intolerance-content-item">
                <div class="title-icon">
                    <span class="intolerance-medium-icon"><i class="fa fa-warning"></i></span>
                    <span>Tomatoes</span>
                </div>
                <span class="intolerance-value">2528.13 rpkm</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar status-high" style="width: 60%;"></div>
                        <div class="intolerance-progress-bar status-success" style="width: 40%;"></div>
                    </div>
                </div>
            </div>
            <!-- Item 3 -->
            <div class="intolerance-content-item">
                <div class="title-icon">
                    <span class="intolerance-medium-icon"><i class="fa fa-warning"></i></span>
                    <span>Tomatoes</span>
                </div>
                <span class="intolerance-value intolerance-value-green">922.70 rpkm</span>
                <div class="intolerance-progress-container mx-3">
                    <div class="intolerance-progress">
                        <div class="intolerance-progress-bar status-medium" style="width: 40%;"></div>
                        <div class="intolerance-progress-bar status-success" style="width: 60%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
