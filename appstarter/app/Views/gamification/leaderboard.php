<style>
    .leaderboard {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        width: 90%;
        margin: 0 auto;
    }

    .player {
        width: 100%;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .player:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .rank {
        font-size: 24px;
        font-weight: bold;
        margin: 10px 0;
    }

    .name {
        font-size: 18px;
        font-weight: 600;
        margin: 10px 0;
    }

    .score {
        font-size: 14px;
        font-weight: 400;
        margin: 10px 0;
    }

    .avatar {
        width: 55px;
        border-radius: 50%;
        margin: 0 auto;
    }

    .rank-1 {
        background-color: #fff9e6;
        height: 300px;
        /*padding-top: 100px;*/
        margin-top: 0;
    }

    .rank-2 {
        background-color: #f2f2f2;
        height: 220px;
        /*padding-top: 23px;*/
        margin-top: 80px;
    }

    .rank-3 {
        background-color: #f5e6d6;
        height: 190px;
        /*padding-top: 12px;*/
        margin-top: 110px;
    }

    .rank-1 .rank i {
        color: gold;
    }

    .rank-2 .rank i {
        color: silver;
    }

    .rank-3 .rank i {
        color: #cd7f32;
    }

    .stats-1, .stats-2, .stats-3 {
        /*transition: height 0.5s;*/
        /*transition: visibility 0s, opacity 0.5s linear;*/
        border: silver solid 1px;
        background-color: lightgray;
        padding: 5px;
    }

    #toggle-stats-1, #toggle-stats-2, #toggle-stats-3 {
        width: 30%;
        cursor: pointer;
    }
</style>

<!-- Leaderboard (currently top 3)-->
<div class="leaderboard">
    <div id="toggle-stats-2">
        <div class="player rank-2">
            <div class="rank"><i class="fa-solid fa-medal"></i></div>
            <?php
            if (isset($aUserScores[1])) {
                if (!empty($aUserScores[1]['profile']))
                    echo '<img src="/' . $aUserScores[1]['profile'] . '" alt="' . $aUserScores[1]['name'] . '" class="avatar">';
                else
                    echo '<img src="/images/profile/profile-empty.png" alt="' . $aUserScores[1]['name'] . '" class="avatar">';
                echo '<div class="name">' . $aUserScores[1]['name'] . '</div>';
                echo '<div class="score">' . $aUserScores[1]['total'] . '</div>';
            }
            ?>
        </div>
        <div class="stats-2" style="height: 0px;" hidden="">
            <b>Punkteaufteilung:</b><br/>
            Abschlussarbeiten: <?= $aUserScores[2]['theses'] ?><br/>
            Lehrleistungen: <?= $aUserScores[2]['teaching'] ?><br/>
            Publikationen: <?= $aUserScores[2]['publication'] ?><br/>
        </div>
    </div>
    <div id="toggle-stats-1">
        <div class="player rank-1">
            <div class="rank"><i class="fa-solid fa-trophy"></i></div>
            <?php
            if (isset($aUserScores[0])) {
                if (!empty($aUserScores[0]['profile']))
                    echo '<img src="/' . $aUserScores[0]['profile'] . '" alt="' . $aUserScores[0]['name'] . '" class="avatar">';
                else
                    echo '<img src="/images/profile/profile-empty.png" alt="' . $aUserScores[0]['name'] . '" class="avatar">';
                echo '<div class="name">' . $aUserScores[0]['name'] . '</div>';
                echo '<div class="score">' . $aUserScores[0]['total'] . '</div>';
            }
            ?>
        </div>
        <div class="stats-1" style="height: 0px;" hidden="">
            <b>Punkteaufteilung:</b><br/>
            Abschlussarbeiten: <?= $aUserScores[0]['theses'] ?><br/>
            Lehrleistungen: <?= $aUserScores[0]['teaching'] ?><br/>
            Publikationen: <?= $aUserScores[0]['publication'] ?><br/>
        </div>
    </div>
    <div id="toggle-stats-3">
        <div class="player rank-3">

            <div class="rank"><i class="fa-solid fa-medal"></i></div>
            <?php
            if (isset($aUserScores[2])) {
                if (!empty($aUserScores[2]['profile']))
                    echo '<img src="/' . $aUserScores[2]['profile'] . '" alt="' . $aUserScores[2]['name'] . '" class="avatar">';
                else
                    echo '<img src="/images/profile/profile-empty.png" alt="' . $aUserScores[2]['name'] . '" class="avatar">';
                echo '<div class="name">' . $aUserScores[2]['name'] . '</div>';
                echo '<div class="score">' . $aUserScores[2]['total'] . '</div>';
            }
            ?>

        </div>
        <div class="stats-3" style="height: 0px;" hidden="">
            <b>Punkteaufteilung:</b><br/>
            Abschlussarbeiten: <?= $aUserScores[2]['theses'] ?><br/>
            Lehrleistungen: <?= $aUserScores[2]['teaching'] ?><br/>
            Publikationen: <?= $aUserScores[2]['publication'] ?><br/>
        </div>
    </div>
</div>

<script>
    let div = document.querySelector("#toggle-stats-2");
    let toggleDiv = document.querySelector(".stats-2");

    document.querySelector("#toggle-stats-1").addEventListener("click", function () {
        if (document.querySelector(".stats-1").style.height === "0px") {
            document.querySelector(".stats-1").style.height = "100px";
            document.querySelector(".stats-1").hidden = false;
        } else {
            document.querySelector(".stats-1").style.height = "0px";
            document.querySelector(".stats-1").hidden = true;
        }
    });
    document.querySelector("#toggle-stats-2").addEventListener("click", function () {
        if (document.querySelector(".stats-2").style.height === "0px") {
            document.querySelector(".stats-2").style.height = "100px";
            document.querySelector(".stats-2").hidden = false;
        } else {
            document.querySelector(".stats-2").style.height = "0px";
            document.querySelector(".stats-2").hidden = true;
        }
    });
    document.querySelector("#toggle-stats-3").addEventListener("click", function () {
        if (document.querySelector(".stats-3").style.height === "0px") {
            document.querySelector(".stats-3").style.height = "100px";
            document.querySelector(".stats-3").hidden = false;
        } else {
            document.querySelector(".stats-3").style.height = "0px";
            document.querySelector(".stats-3").hidden = true;
        }
    });
</script>