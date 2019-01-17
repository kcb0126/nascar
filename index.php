<?php
    $handle = fopen("drivers.csv", "r");

    $drivers = [];

    $isHeader = true;

    while($data = fgetcsv($handle, 1000, ",")) {
        if($isHeader) {
            $isHeader = false;
            continue;
        }
        $drivers[] = [
            "ID" => $data[0],
            "Name" => $data[1],
            "Salary" => $data[2],
            "Min" => $data[3],
            "Max" => $data[4],
            "Proj" => $data[5]
        ];
        $notused = 0;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NASCAR OPTIMIZER</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="css/jquery-ui.structure.min.css">
</head>
<body>

<div class="container pt-5">

    <div class="container-fluid p-3 mb-4 border border-secondary">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <span class="text-danger">Salary Range(0 to 50000): </span>
                <span id="min" class="text-info">$0</span> to <span id="max" class="text-info">$10000</span>
                <div class="mt-3" id="slider"></div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-7">
                <span class="text-danger"># of Lineups</span><br />
                <label for="spinner"></label>
                <input id="spinner" name="value">
            </div>

            <div class="col-lg-2 col-md-2 col-sm-5">
                <button id="optimize-button" class="btn btn-danger">Optimize Lineups!</button>
                <button id="download-button" class="btn btn-info mt-1">Download Lineups!</button>
            </div>
        </div>

    </div>

    <div id="buttons-div" class="container p-3 mb-1">
        <button id="input-button" class="btn btn-info border">Input</button>
        <button id="exposure-button" class="btn btn-light border">Exposure</button>
        <button id="lineups-button" class="btn btn-light border">Lineups</button>
        <button id="userguide-button" class="btn btn-light border" style="display: none;">User Guide</button>
    </div>

    <div id="input-table" class="container p-3 border border-secondary">
        <div class="row">
            <div class="col-1"><span>ID</span></div>
            <div class="col-4"><span>Driver</span></div>
            <div class="col-1"><span>Salary</span></div>
            <div class="col-2"><span>Min%</span></div>
            <div class="col-2"><span>Max%</span></div>
            <div class="col-2"><span>Proj</span></div>
        </div>
        <form id="form-data">
            <input id="minsalary" type="hidden" name="minsalary" value="0">
            <input id="maxsalary" type="hidden" name="maxsalary" value="5000">
            <input id="lineups" type="hidden" name="lineups" value="500">


        <hr />
        <?php
            foreach ($drivers as $driver) {
        ?>
                <div class="row mb-2">
                    <div class="col-1"><?=$driver['ID']?></div>
                    <div class="col-4"><?=$driver['Name']?></div>
                    <div class="col-1">$<?=number_format($driver['Salary'])?></div>
                    <div class="col-2"><input name="min<?=$driver['ID']?>" class="form-control" value="<?=$driver['Min']?>"></div>
                    <div class="col-2"><input name="max<?=$driver['ID']?>" class="form-control" value="<?=$driver['Max']?>"></div>
                    <div class="col-2"><input name="proj<?=$driver['ID']?>" class="form-control" value="<?=$driver['Proj']?>"></div>
                </div>
        <?php
            }
        ?>
        </form>
    </div>

    <div id="exposure-table" class="container p-3 border border-secondary" style="display: none;">
        <div class="row">
            <div class="col-1">ID</div>
            <div class="col-4">Driver</div>
            <div class="col-1">Salary</div>
            <div class="col-2">Proj</div>
            <div class="col-2">Min LU</div>
            <div class="col-2">Max LU</div>
        </div>

        <hr />
        <?php
        foreach ($drivers as $driver) {
            ?>
            <div class="row mb-2">
                <div class="col-1"><?=$driver['ID']?></div>
                <div class="col-4"><?=$driver['Name']?></div>
                <div class="col-1">$<?=number_format($driver['Salary'])?></div>
                <div class="col-2"><?=$driver['Proj']?></div>
                <div class="col-2"><?=$driver['Min'] / 100 ?></div>
                <div class="col-2"><?=$driver['Max'] / 100?></div>
            </div>
            <?php
        }
        ?>

    </div>

    <div id="lineups-table" class="container p-3 border border-secondary" style="display: none;">
        <div class="row">
            <div class="col-2">D1</div>
            <div class="col-2">D2</div>
            <div class="col-2">D3</div>
            <div class="col-2">D4</div>
            <div class="col-2">D5</div>
            <div class="col-2">D6</div>
        </div>

        <hr />
        <div id="lineups-div">
            <div class="row mb-2">
                <div class="col-2"><?=$driver['ID']?></div>
                <div class="col-2"><?=$driver['Name']?></div>
                <div class="col-2">$<?=number_format($driver['Salary'])?></div>
                <div class="col-2"><?=$driver['Proj']?></div>
                <div class="col-2"><?=$driver['Min'] / 100 ?></div>
                <div class="col-2"><?=$driver['Max'] / 100?></div>
            </div>
        </div>

    </div>

</div>


<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.mousewheel.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>

    $( "#slider" ).slider({
        range: true,
        min: 0,
        max: 50000,
        values: [ 0, 50000 ],
        slide: function (event, ui) {
            $("#min").text("$" + ui.values[0]);
            $("#max").text("$" + ui.values[1]);

            $("#minsalary").val(ui.values[0]);
            $("#maxsalary").val(ui.values[1]);
        }
    });

    var spinner = $( "#spinner" ).spinner({
        min: 1,
        max: 150,
        change: function(event, ui) {
            $("#lineups").val($("#spinner").val());
        },
        spin: function(event, ui) {
            $("#lineups").val($("#spinner").val());
        }
    });
    spinner.spinner("value", 10);

    $("#optimize-button").click(function() {
        $.post(
            "lineups.php",
            $("#form-data").serialize(),
            function(resp) {
                let lineupsDiv = $("#lineups-div");
                lineupsDiv.empty();

                resp.forEach(function(lineup) {
                    let lineupHTML = '<div class="row mb-2">';
                    lineup.forEach(function(player) {
                        lineupHTML = lineupHTML + `<div class="col-2">${player}</div>`;
                    });
                    lineupHTML = lineupHTML + '</div>';
                    lineupsDiv.append($(lineupHTML));
                });

                $("#buttons-div").show();
            },
            'JSON'
        );

    });

    $("#download-button").click(function() {
        $.post(
            "download.php",
            $("#form-data").serialize(),
            function (resp) {

                console.info(resp);

                var link = document.createElement("a");
                link.download = "output.csv";
                link.href = "output.csv";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                delete link;

            },
            'JSON'
        );
    });

    $("#input-button").click(function() {
        $("#input-button").removeClass("btn-light").addClass("btn-info");
        $("#exposure-button").removeClass("btn-info").addClass("btn-light");
        $("#lineups-button").removeClass("btn-info").addClass("btn-light");
        $("#userguide-button").removeClass("btn-info").addClass("btn-light");

        $("#input-table").show();
        $("#exposure-table").hide();
        $("#lineups-table").hide();
    });

    $("#exposure-button").click(function() {
        $("#exposure-button").removeClass("btn-light").addClass("btn-info");
        $("#input-button").removeClass("btn-info").addClass("btn-light");
        $("#lineups-button").removeClass("btn-info").addClass("btn-light");
        $("#userguide-button").removeClass("btn-info").addClass("btn-light");

        $("#input-table").hide();
        $("#exposure-table").show();
        $("#lineups-table").hide();
    });

    $("#lineups-button").click(function() {
        $("#lineups-button").removeClass("btn-light").addClass("btn-info");
        $("#input-button").removeClass("btn-info").addClass("btn-light");
        $("#exposure-button").removeClass("btn-info").addClass("btn-light");
        $("#userguide-button").removeClass("btn-info").addClass("btn-light");

        $("#lineups-table").show();
        $("#input-table").hide();
        $("#exposure-table").hide();
    });

    $("#userguide-button").click(function() {
        $("#userguide-button").removeClass("btn-light").addClass("btn-info");
        $("#input-button").removeClass("btn-info").addClass("btn-light");
        $("#exposure-button").removeClass("btn-info").addClass("btn-light");
        $("#lineups-button").removeClass("btn-info").addClass("btn-light");
    });

</script>

</body>
</html>