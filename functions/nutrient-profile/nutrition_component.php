    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Circular Chart */
        .chart-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin-bottom: 30px;
        }

        .chart-container .chart-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .chart-container .chart-text small {
            display: block;
            font-size: 14px;
            font-weight: normal;
            color: #777;
        }

        /* Nutritional Details */
        .nutrition-details {
            display: flex;
            justify-content: space-between;
            text-align: left;
            gap: 30px;
            width: 30%;
        }

      
        .nutrition-details .nutrient .value {
            font-size: 22px;
        }

        .label {
            position: relative;
        }

        .label::before {
            position: absolute;
            content: '';
            width: 100px;
            height: 4px;
            top: -10px;
        }

        .nutrient[data-color="blue"] .label::before {
            background-color: #6189ce;
        }

        .nutrient[data-color="orange"] .label::before {
            background-color: #ec9347; 
        }

        .nutrient[data-color="green"] .label::before {
            background-color: #72bf44;
        }
        
        .nutrient p {
            margin: 0;
        }

        .percent-blue {
            color:#6189ce;
            font-weight: 800;
        }
        .percent-orange {
            color: #ec9347;
             font-weight: 800;
        }
        .percent-green {
            color:#72bf44;
             font-weight: 800;
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .nutrition-details {
                flex-wrap: wrap;
                gap: 15px;
            }

            .nutrition-details .nutrient {
                flex: 1 1 calc(50% - 10px);
            }
        }
    </style>

<style>
    .custom-nutrition-table {
        border-radius: 20px;
        border: 1px solid #ccc;
        background-color: #f9fafb;
        overflow: hidden;
        overflow-x: auto;
    }

    .custom-nutrition-table .table {
        width: 100%;
        overflow: hidden;
    }

    .custom-nutrition-table thead th {
        font-size: 14px;
        font-weight: bold;
        text-align: left;
        color: #8c96a5;
        border-bottom: 2px solid #ddd;
    }

    .custom-nutrition-table tbody tr {
        border-bottom: 1px solid #eee;
    }

    .custom-nutrition-table tbody td {
        font-size: 14px;
        color: #4f4f4f;
        padding: 10px;
        vertical-align: top;
    }

    .custom-nutrition-table .nutrient-name {
        display: block;
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }

    .custom-nutrition-table .nutrient-value {
        display: block;
        font-size: 14px;
        color: #666;
    }

    .custom-nutrition-table tbody td:nth-child(2),
    .custom-nutrition-table tbody td:nth-child(4) {
        font-weight: bold;
        color: #8c96a5;
        text-align: right;
    }
</style>


<div class="container mt-5">

    <div class="d-flex flex-wrap align-items-center justify-content-evenly">
        <!-- Circular Chart -->
        <div class="chart-container">
            <canvas id="calorieChart"></canvas>
            <div class="chart-text">
                639 kcal<br>
                <small>per serving</small>
            </div>
        </div>

        <!-- Nutritional Details -->
        <div class="nutrition-details">
            <div class="nutrient" data-color="blue">
                <p class="label" >Protein</p>
                <p class="value">47g</p>
                <p class="percent-blue">30%</p>
            </div>
            <div class="nutrient" data-color="orange">
                <p class="label" >Fat</p>
                <p class="value">46g</p>
                <p class="percent-orange">66%</p>
            </div>
            <div class="nutrient" data-color="green">
                <p class="label" >Net Carbs</p>
                <p class="value">6g</p>
                <p class="percent-green">4%</p>
            </div>
        </div>
    </div>

    <!-- Nutrition Table -->
    <div class="nutrition-table custom-nutrition-table">
    <table class="table">
        <thead>
            <tr>
                <th>Amount per serving</th>
                <th>% Daily Value*</th>
                <th>Amount per serving</th>
                <th>% Daily Value*</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span class="nutrient-name">Calories</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">386.77kcal</span>
                        <span class="nutrient-percent">19%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Potassium</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">1332.34mg</span>
                        <span class="nutrient-percent">38%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="nutrient-name">Total Fat</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">21.39g</span>
                        <span class="nutrient-percent">31%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Iron</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">2.65mg</span>
                        <span class="nutrient-percent">19%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="nutrient-name">Carbs</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">20.67g</span>
                        <span class="nutrient-percent">8%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Zinc</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">4.94mg</span>
                        <span class="nutrient-percent">49%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="nutrient-name">Sugars</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">11.54g</span>
                        <span class="nutrient-percent">13%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Phosphorus</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">309.33mg</span>
                        <span class="nutrient-percent">44%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="nutrient-name">Protein</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">28.75g</span>
                        <span class="nutrient-percent">57%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Vitamin A</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">129.88mcg</span>
                        <span class="nutrient-percent">16%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="nutrient-name">Sodium</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">739.64mg</span>
                        <span class="nutrient-percent">37%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Vitamin C</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">62.43mg</span>
                        <span class="nutrient-percent">78%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="nutrient-name">Fiber</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">2.16g</span>
                        <span class="nutrient-percent">8%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Thiamin B1</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">0.15mg</span>
                        <span class="nutrient-percent">14%</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="nutrient-name">Saturated Fat</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">4.51g</span>
                        <span class="nutrient-percent">23%</span>
                    </div>
                </td>
                <td>
                    <span class="nutrient-name">Riboflavin B2</span>
                </td>
                <td>
                    <div class="d-flex gap-3 justify-content-end">
                        <span class="nutrient-value">0.22mg</span>
                        <span class="nutrient-percent">16%</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>



</div>

<script>
    // Chart.js Doughnut Chart
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('calorieChart').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Protein', 'Fat', 'Net Carbs'],
                datasets: [{
                    data: [30, 66, 4],
                    backgroundColor: 
                    [
                        '#6189ce',  //blue
                        '#fde0c7',  //orange
                        '#72bf44'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                maintainAspectRatio: false
            }
        });
    });
</script>

