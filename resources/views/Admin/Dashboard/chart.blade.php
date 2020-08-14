<div class="col-sm-4 col-md-4 col-lg-4">
    <div class="card card-min-height">
        <div class="card-header">
            Resource Usage
        </div>
        <div class="card-body" style="padding: 5px;">
            <canvas id="chart-area" height="205px"></canvas>
        </div>
    </div>
</div>
<div class="col-sm-4 col-lg-4">
    <div class="card card-min-height">
        <div class="card-header">
            Last six month products
        </div>
        <div class="card-body" style="padding: 5px;">
            <?php
            $productList = getSixMonthProducts();
            $productCounts = $productList['counts'];
            $productMonths =  $productList['months'];
            ?>
            <canvas id="product-bar-chart" height="205px"></canvas>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/dist/Chart.min.js') }}"></script>
<script type="text/javascript">
    window.onload = function() {
        var ctx = document.getElementById('chart-area').getContext('2d');
        window.myPie = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        {{ $users }},
                        {{ $posts }},
                        {{ $categories }},
                        {{ $products }},
                    ],
                    backgroundColor: [
                        '#7c69ef',
                        '#42ba96',
                        '#ffc107',
                        '#161c2d'
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Users',
                    'Posts',
                    'Categories',
                    'Products'
                ]
            },
            options: {
                responsive: true
            }
        });

        var pctx = document.getElementById('product-bar-chart').getContext('2d');
        window.myBar = new Chart(pctx, {
            type: 'bar',
            data: {
                labels: [{!! $productMonths !!}],
                datasets: [{
                    label: 'Products',
                    backgroundColor: '#161c2d',
                    borderColor: '#161c2d',
                    borderWidth: 1,
                    data: [{{ $productCounts }}]
                }]

            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: false,
                    text: 'Products Bar Chart'
                }
            }
        });
    };
</script>
