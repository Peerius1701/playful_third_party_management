<?php
if(empty($sImagePath))
    $sImagePath = '';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Accountdaten</title>
    <?= view('head') ?>
    <style>
        .sng-img-container {
            position: relative;
            width: 100px;
            height: 100px;
            overflow: hidden;
            margin: 10px;
            cursor: pointer;
            border: 1px solid lightgray;
        }

        .sng-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .2s ease-in-out;
        }

        .sng-img-container:hover img {
            transform: scale(1.25);
        }

        .sng-img-container:active ~ .preview-container,
        .sng-img-container:focus ~ .preview-container {
            display: flex;
        }

        .img-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 250px;
            height: 250px;
            margin: 20px auto;
            border: 1px solid lightgray;
        }

        #preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .preview-text {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<!-- display navbar -->
<?= view('navbar') ?>

<!-- Header -->
<header class="w3-container w3-red w3-center ptpm-header">
    <h4 class="w3-margin w3-jumbo ptpm-heading-title">Profilbild</h4>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
        <div>
            <?= view('validation_account', array($show_alert, $alert_info, $alert_status)) ?>
            <h1>Profilbild bearbeiten: </h1>
            <form action="<?= base_url('/profile/edit_profile_picture/' . $iUserID) ?>" method="post">

                <input type="hidden" id="profile_picture" name="profile_picture" value="<?=$sImagePath?>">



                <div class="preview-container">
                    <img id="preview-img" src="">
                    <div class="preview-text">Bild wählen</div>
                </div>

                <div class="img-container">
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-1.jpg" class="thumbnail" alt="profile-image-1">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-2.png"  class="thumbnail" alt="profile-image-2">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-3.jpg" class="thumbnail" alt="profile-image-3">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-4.jpg" class="thumbnail" alt="profile-image-4">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-5.jpg" class="thumbnail" alt="profile-image-5">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-6.jpg" class="thumbnail" alt="profile-image-6">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-7.jpg" class="thumbnail" alt="profile-image-7">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-8.jpg" class="thumbnail" alt="profile-image-8">
                    </div>
                    <!--<div class="sng-img-container">
                        <img src="/images/profile/profile-9.jpg" class="thumbnail" alt="profile-image-9">
                    </div>-->
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-10.jpg" class="thumbnail" alt="profile-image-10">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-11.jpg" class="thumbnail" alt="profile-image-11">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-12.jpg" class="thumbnail" alt="profile-image-12">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-13.jpg" class="thumbnail" alt="profile-image-13">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-14.jpg" class="thumbnail" alt="profile-image-14">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-15.jpg" class="thumbnail" alt="profile-image-15">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-16.jpg" class="thumbnail" alt="profile-image-16">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-17.jpg" class="thumbnail" alt="profile-image-17">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-18.jpg" class="thumbnail" alt="profile-image-18">
                    </div>
                    <div class="sng-img-container">
                        <img src="/images/profile/profile-19.jpg" class="thumbnail" alt="profile-image-19">
                    </div>
                </div>

                <input type="submit" class="btn w3-padding-large w3-large add-button" value="Speichern">
            </form>
        </div>
    </div>
</div>


<div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 class="w3-margin w3-xlarge">Serious Games</h1>
</div>

<?= view('footer') ?>

<script>
    const thumbnails = document.querySelectorAll('.thumbnail');
    const previewImg = document.querySelector('#preview-img');
    const previewText = document.querySelector('.preview-text');
    const profileInputSaver = document.getElementById("profile_picture");

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            previewImg.src = this.src;
            previewImg.style.display = 'block';
            previewText.style.display = 'none';
            profileInputSaver.value = this.src;
        });
    });

    window.onload = function() {
        if('<?=$sImagePath?>'){
            previewImg.src = '<?=$sImagePath?>';
            previewImg.style.display = 'block';
            previewText.style.display = 'none';
            profileInputSaver.value = '<?=$sImagePath?>';
        }

    };
</script>

</body>
</html>
