<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <center>
                            <h4 class="title">Data Eksternal Weather API - REST API</h4>
                        </center>
                    </div>
                    <div class="content">
                        <?php
                            $curl = curl_init();
                            $url = "https://api.open-meteo.com/v1/forecast?latitude=-7.8011945&longitude=110.364917&current_weather=true";
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            $res = curl_exec($curl);
                            $json = json_decode($res, true);

                                echo '<table class="table table-bordered table-striped">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>Longitude</th>';
                                            echo '<th>Latitude</th>';
                                            echo '<th>Temperature (&deg;C)</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                        echo '<tr>';
                                            echo '<td>' . $json['longitude'] . '</td>';
                                            echo '<td>' . $json['latitude'] . '</td>';
                                            echo '<td>' . $json['current_weather']['temperature'] . '</td>';
                                        echo '</tr>';
                                    echo '</tbody>';
                                echo '</table>';
                            curl_close($curl);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
