<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                Visitors Report
            </div>
            <div class="card-body" style="padding: 5px;">
                <div id="world-map-markers" style="height: 325px;"></div>
            </div>
        </div>

    </div>
</div>

<link href="{{ asset('assets/js/maps/jquery-jvectormap-2.0.5.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('assets/js/maps/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/js/maps/jquery-jvectormap-world-mill-en.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('#world-map-markers').vectorMap({
            map              : 'world_mill_en',
            scaleColors: ['#C8EEFF', '#0071A4'],
            normalizeFunction: 'polynomial',
            hoverOpacity     : 0.,
            hoverColor       : false,
            backgroundColor  : 'transparent',
            regionStyle      : {
                initial      : {
                    fill            : 'rgba(210, 214, 222, 1)',
                    'fill-opacity'  : 1,
                    stroke          : 'none',
                    'stroke-width'  : 0,
                    'stroke-opacity': 1
                },
                hover        : {
                    'fill-opacity': 0.7,
                    cursor        : 'pointer'
                },
                selected     : {
                    fill: 'yellow'
                },
                selectedHover: {}
            },
            markerStyle      : {
                initial: {
                    fill  : '#00a65a',
                    stroke: '#383f47'
                }
            },
            markers : {!! getAllUserLatLng() !!}
        });
    });
</script>
