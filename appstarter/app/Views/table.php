
<table id="table1" class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
        <?php
        $bReportSingleProject = false;
        if($aColumns[1] === 'Zuwendungsbescheid'){
            $bReportSingleProject = true;
        }//by single project report no enhanced table
        foreach ($aColumns as $sColumn)
            echo '<th scope="col">' . $sColumn . '</th>';
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $empty = false;
    foreach ($aData as $aRow) {
        if (sizeof($aRow) == 0)
            continue;
        echo '<tr>';

        if (sizeof($aRow) >= 1)
            echo '<th scope="row">' . $aRow[0] . '</th>';

        for ($i = 1; $i < sizeof($aRow); $i++)
            echo '<td>' . $aRow[$i] . '</td>';

        echo '</tr>';
    }
    if(empty($aData)) {
        echo '<tr>';
        echo '<td colspan="' . sizeof($aColumns) . '">' . "<em>Es sind keine Einträge vorhanden.</em>" . '</td>';
        echo '</tr>';
        $empty = true;
    }
    ?>
    </tbody>
</table>

<script>
    $(document).ready( function () {
        var empty = <?php echo json_encode($empty);?>;
        var bReportSingleProject = <?php echo json_encode($bReportSingleProject); ?>;
        if(!empty && !bReportSingleProject){
            $('#table1').DataTable({
                "language": {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/German.json',
                },
                "lengthMenu": [[ 5, 10, 20, -1 ],[ 5, 10, 20, "ALLE" ]]
            });
        }
    } );
</script>
