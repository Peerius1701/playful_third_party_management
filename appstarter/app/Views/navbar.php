<?php

$sLinkHome = base_url(''); //home
// Users
$sLinkEmployees = base_url('/users/show_employees'); //Mitarbeiter
$sLinkManagement = base_url('/users/show_managements'); //Management

// Projekte
$sLinkInvest = base_url('/projects/show_invests'); //Invest
$sLinkBusinessTrip = base_url('/projects/show_business_trips'); //Reise
$sLinkProject = base_url('/projects/show_projects'); //Projekt
//$sLinkFinanceType = base_url('/projects/show_finance_types'); //Finanzierungstyp
$sLinkStudentAssistants = base_url('/projects/show_student_assistants'); //Studentische Hilfskräfte
$sLinkYoungScientists = base_url('/projects/show_young_scientists'); //Wissenschaftlicher Nachwuchs

// Formulare
$sLinkTeachingServices = base_url('/forms/show_teaching_services'); //Lehrleistungen
$sLinkTheses = base_url('/forms/show_theses'); //Abschlussarbeiten
$sLinkPublications = base_url('/forms/show_publications'); //Publikationen
$sLinkConferencesImpact = base_url('/forms/show_conferences_impact'); //Konferenz - Impact
$sLinkJournalsImpact = base_url('/forms/show_journals_impact'); //Journal - Impact

// Reports
$sLinkAccounts = base_url('/reports/accounts'); //Konten
$sLinkProjectOverview = base_url('/reports/project_overview'); //Projektübersicht
$sLinkIndividualProject = base_url('/reports/project'); //Einzelprojekt
$sLinkBudgetOverview = base_url('/reports/budget_overview'); //Übersicht - Budget

// Pando
$sLinkPandoReport = base_url('/pando/report'); //Pando (Report)
$sLinkPandoEmployee = base_url('/pando/report_employee'); //Pando Mitarbeiter
$sLinkPandoForm = base_url('/pando/form'); //Pando (Formular)

// Profile
$sLinkAccountData = base_url('/profile/show_account_data/(:num)'); // Show Account Data
$sProfileLink = base_url('/profile/account_data/' . $_SESSION['session_id']);
$sLogoutLink =  base_url('/logout');
$sEditProfilePictureLink = base_url('/profile/edit_profile_picture/' . $_SESSION['session_id']);

/*
Der Titel der Kategorie entspricht dem Namen des entsprechenden Controllers
 */
$bCategory1Active = ($sCategory == 'Home');     // HOME
$bCategory2Active = ($sCategory == 'UserForms');
$bCategory3Active = ($sCategory == 'Projects');
$bCategory4Active = ($sCategory == 'Forms');
$bCategory5Active = ($sCategory == 'Reports');
$bCategory6Active = ($sCategory == 'Pando');
$bCategory7Active = ($sCategory == 'Profile');

if($bCategory7Active)
    $sUserIcon = '<i class="fa-solid fa-circle-user user-profile-selected" id="user-info"></i>';
else
    $sUserIcon = '<i class="fa-solid fa-circle-user" id="user-info"></i>';

$oUserModel = new \App\Models\userforms\user\UserModel();
$sUserIconPath = $oUserModel->getUser($_SESSION['session_id'])['profile_picture'];

if(!empty($sUserIconPath))
    if($bCategory7Active)
        $sUserIcon = '<div  id="user-info-icon"><img src="/'.$sUserIconPath.'" class="user-info-icon" alt="Profilbild"></div>';
    else
        $sUserIcon = '<div  id="user-info-icon"><img src="/'.$sUserIconPath.'" class="user-info-icon user-profile-selected" alt="Profilbild"></div>';

?>

<!-- Navbar and Dropdown -->
<div class="w3-top">
    <div class="w3-bar w3-red w3-card w3-left-align w3-large">


        <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-white w3-large w3-red"
           href="javascript:void(0);" onclick="toggleElement('navDemo')" title="Toggle Navigation Menu"><i
                    class="fa fa-bars"></i></a>

        <!--        <div id="dropdown-icon" class="w3-hide-medium w3-hide-large w3-red" ><i class="fa-solid fa-caret-down"></i></div>-->

        <a href="<?= $sLinkHome ?>" class="w3-bar-item w3-button w3-padding-large <?= $bCategory1Active ? "btn-selected dropdown-icon" : ( $bCategory7Active ? 'w3-hover-white' : "w3-hide-small w3-hover-white") ?>">
            <!--            <i class="sg-icon nav-bar-icon"></i>-->
            <i class='fas fa-home nav-bar-icon'></i>
            Home
        </a>

        <div class="dropdown w3-dropdown-hover">
            <a class="w3-bar-item w3-button w3-padding-large <?= $bCategory2Active ? "btn-selected" : "w3-hide-small w3-hover-white" ?>">

                <i class="fa-solid fa-users-between-lines nav-bar-icon"></i>
                User
                <div class="w3-hide-medium w3-hide-large dropdown-icon" ><i class="fa-solid fa-caret-down"></i></div>
            </a>
            <div class="dropdown-content">
                <a href=<?= $sLinkEmployees ?>>Mitarbeitende</a>
                <a href=<?= $sLinkManagement ?>>Management</a>
            </div>
        </div>

        <div class="dropdown w3-dropdown-hover">
            <a class="w3-bar-item w3-button w3-padding-large <?= $bCategory3Active ? "btn-selected" : "w3-hide-small w3-hover-white" ?>">

<!--                <i class="fa-solid fa-bars-progress nav-bar-icon"></i>-->
                <i class="fa-solid fa-folder nav-bar-icon"></i>
                Formulare P&P
                <div class="w3-hide-medium w3-hide-large dropdown-icon" ><i class="fa-solid fa-caret-down"></i></div>
            </a>
            <div class="dropdown-content" style="min-width: 235px;">
                <a href=<?= $sLinkInvest ?>>Invest</a>
                <a href=<?= $sLinkBusinessTrip ?>>Reise</a>
                <?php
                    if($_SESSION['user_type']!=='management'){
                        echo '<a href='.$sLinkProject.'>Projekt</a>';
                    }//Finazierung fehlt
                ?>
                <!--<a href=''>Finanzierung</a>-->
                <a href=<?=$sLinkStudentAssistants ?>>Studentische Hilfskräfte</a>
            </div>
        </div>

        <div class="dropdown w3-dropdown-hover">
            <a class="w3-bar-item w3-button w3-padding-large <?= $bCategory4Active ? "btn-selected" : "w3-hide-small w3-hover-white" ?>">

                <i class="fa-regular fa-pen-to-square nav-bar-icon"></i>
                <!--                <i class="fa-brands fa-wpforms nav-bar-icon"></i>-->
                Formulare F&L
                <div class="w3-hide-medium w3-hide-large dropdown-icon" ><i class="fa-solid fa-caret-down"></i></div>
            </a>

            <div class="dropdown-content" style="min-width: 235px;">
                <a href=<?= $sLinkPublications ?>>Publikationen</a>
                <?php
                if($_SESSION['user_type']!=='management'){
                    echo '<a href='.$sLinkJournalsImpact.'>Journal-Impact</a>';
                    echo '<a href='.$sLinkConferencesImpact.'>Konferenz-Impact</a>';
                }
                ?>
                <a href=<?= $sLinkTeachingServices ?>>Lehrleistungen</a>
                <?php
                if($_SESSION['user_type']!=='management'){
                    echo '<a href='.$sLinkTheses.'>Abschlussarbeiten</a>';
                    echo '<a href='.$sLinkYoungScientists.'>Wissenschaftlicher Nachwuchs</a>';
                }
                ?>
            </div>
        </div>

        <div class="dropdown w3-dropdown-hover">
            <a class="w3-bar-item w3-button w3-padding-large <?= $bCategory5Active ? "btn-selected" : "w3-hide-small w3-hover-white" ?>">

                <i class="fa-solid fa-sheet-plastic nav-bar-icon"></i>
                Reports
                <div class="w3-hide-medium w3-hide-large dropdown-icon" ><i class="fa-solid fa-caret-down"></i></div>
            </a>
            <div class="dropdown-content">
                <?php
                if($_SESSION['user_type']!=='employee'){
                    echo '<a href='.$sLinkAccounts.'>Konten</a>';
                    echo '<a href='.$sLinkProjectOverview.'>Projektübersicht</a>';
                }
                ?>
                <a href=<?= $sLinkIndividualProject ?>>Einzelprojekt</a>
                <?php
                if($_SESSION['user_type']!=='employee'){
                    echo '<a href='.$sLinkBudgetOverview.'>Budgetübersicht</a>';
                }
                ?>
            </div>
        </div>

        <div class="dropdown w3-dropdown-hover">
            <a class="w3-bar-item w3-button w3-padding-large <?= $bCategory6Active ? "btn-selected" : "w3-hide-small w3-hover-white" ?>">

                <i class="fa-solid fa-medal nav-bar-icon"></i>
                Pando
                <div class="w3-hide-medium w3-hide-large dropdown-icon" ><i class="fa-solid fa-caret-down"></i></div>
            </a>
            <div class="dropdown-content" style="min-width: 160px;">
                <a href=<?= $sLinkPandoForm ?>>Formular</a>
                <a href=<?= $sLinkPandoReport ?>>Report</a>
                <?php
                if($_SESSION['user_type']!=='management'){
                    echo '<a href='.$sLinkPandoEmployee.'>Report Mitarbeitende</a>';
                }
                ?>
            </div>
        </div>

        <div class="user-info-button dropdown w3-right  <?= $bCategory7Active ? "user-profile-selected on-user-profile" : "" ?>">
            <?=$sUserIcon?>
            <div class="dropdown-user-profile">
                <a href="<?= $sProfileLink ?>">Profil<i class="medium-padding-left fa-solid fa-id-card"></i></a>
                <a href="<?= $sEditProfilePictureLink ?>" style="border-bottom-style: none" >Profilbild <i class="medium-padding-left fa-solid fa-circle-user"></i></i></a>
                <a href="<?= $sLogoutLink ?>" id="dropdown-abmelden" >Abmelden<i class="medium-padding-left fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </div>
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium w3-large">
        <a href="<?= $sLinkHome ?>" style="display:<?= $bCategory1Active ? "none" : "block" ?>" class="toggled-bar-item w3-button w3-padding-large">
            <i class='fas fa-home nav-bar-icon'></i>
            Home</a>

        <a onclick="toggleDropdown(['UserDD1', 'UserDD2'])" style="display:<?= $bCategory2Active ? "none" : "block" ?>" class="toggled-bar-item w3-button w3-padding-large">
            <i class="fa-solid fa-users-between-lines nav-bar-icon"></i>
            User
            <div class="toggled-item-bar-icon">
                <i class="fa-solid fa-caret-down"></i>
            </div> </a>
            <a href="<?= $sLinkEmployees ?>" id="UserDD1" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Mitarbeitende</a>
            <a href="<?= $sLinkManagement ?>"  id="UserDD2" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Management</a>

        <a onclick="toggleDropdown(['ProjectDD1', 'ProjectDD2', 'ProjectDD3', 'ProjectDD4', 'ProjectDD5'])" style="display:<?= $bCategory3Active ? "none" : "block" ?>" class="toggled-bar-item w3-button w3-padding-large">
<!--            <i class="fa-solid fa-bars-progress nav-bar-icon"></i>-->
            <i class="fa-solid fa-folder nav-bar-icon"></i>
            Formulare P&P
            <div class="toggled-item-bar-icon">
                <i class="fa-solid fa-caret-down"></i>
            </div></a>
            <a href="<?= $sLinkInvest ?>"  id="ProjectDD1" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Invest</a>
            <a href="<?= $sLinkBusinessTrip ?>"  id="ProjectDD2" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Reise</a>

            <?php
                if($_SESSION['user_type']!=='management'){
                    echo '<a href="'.$sLinkProject .'" id="ProjectDD3" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Projekt</a>';
                }
            ?>
            <!--<a href=""  id="ProjectDD4" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Finanzierung</a>-->
            <a href="<?= $sLinkStudentAssistants ?>"  id="ProjectDD5" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Studentische Hilfskräfte</a>

        <a onclick="toggleDropdown(['FormDD1', 'FormDD2', 'FormDD3', 'FormDD4', 'FormDD5', 'FormDD6'])" style="display:<?= $bCategory4Active ? "none" : "block" ?>" class="toggled-bar-item w3-button w3-padding-large">
            <i class="fa-regular fa-pen-to-square nav-bar-icon"></i>
            Formulare F&L
            <div class="toggled-item-bar-icon">
                <i class="fa-solid fa-caret-down"></i>
            </div></a>
            <a href="<?= $sLinkPublications ?>" id="FormDD3" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Publikationen</a>
        <?php
            if($_SESSION['user_type']!=='management'){
                echo '<a href="'. $sLinkJournalsImpact .'" id="FormDD4" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Journal-Impact</a>
                      <a href="'. $sLinkConferencesImpact .'" id="FormDD6" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Konferenz-Impact</a>';
            }
        ?>
            <a href="<?= $sLinkTeachingServices ?>"  id="FormDD1" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Lehrleistungen</a>
        <?php
            if($_SESSION['user_type']!=='management'){
                echo '<a href="'. $sLinkTheses .'" id="FormDD2" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Abschlussarbeiten</a>
                      <a href="'. $sLinkYoungScientists .'" id="FormDD5" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Wissenschaftlicher Nachwuchs</a>';
            }
        ?>

        <a onclick="toggleDropdown(['ReportDD1', 'ReportDD2', 'ReportDD3', 'ReportDD4'])" style="display:<?= $bCategory5Active ? "none" : "block" ?>" class="toggled-bar-item w3-button w3-padding-large">
            <i class="fa-solid fa-sheet-plastic nav-bar-icon"></i>
            Reports
            <div class="toggled-item-bar-icon">
                <i class="fa-solid fa-caret-down"></i>
            </div></a>
            <?php
                if($_SESSION['user_type']!=='employee'){
                    echo '<a href="' . $sLinkAccounts .'"  id="ReportDD1" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Konten</a>
                          <a href="' . $sLinkProjectOverview .'"  id="ReportDD2" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Projektübersicht</a>';
                }
            ?>
            <a href="<?= $sLinkIndividualProject ?>"  id="ReportDD3" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Einzelprojekt</a>
            <?php
                if($_SESSION['user_type']!=='employee'){
                    echo '<a href="'. $sLinkBudgetOverview .'"  id="ReportDD4" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Budgetübersicht</a>';
                }
            ?>

        <a onclick="toggleDropdown(['PandoDD1', 'PandoDD2', 'PandoDD3'])" style="display:<?= $bCategory6Active ? "none" : "block" ?>" class="toggled-bar-item w3-button w3-padding-large">
            <i class="fa-solid fa-medal nav-bar-icon"></i>
            Pando
            <div class="toggled-item-bar-icon">
                <i class="fa-solid fa-caret-down"></i>
            </div></a>
            <a href="<?= $sLinkPandoForm ?>"  id="PandoDD1" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Formular</a>
            <a href="<?= $sLinkPandoReport ?>"  id="PandoDD2" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Report</a>
        <?php
            if($_SESSION['user_type']!=='management'){
                echo '<a href="'. $sLinkPandoEmployee .'"  id="PandoDD3" style="display:none" class="w3-bar-item small-navbar-button small-dropdown-padding">Report Mitarbeiter</a>';
            }
        ?>

    </div>

    <script>
        // Used to toggle an element with the specified id
        function toggleElement(id) {
            const x = document.getElementById(id);
            if (x.className.indexOf("w3-show") === -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }

        // Will hide or show the elements with the ids defined in idArray
        function toggleDropdown(idArray){
            for (const id of idArray) {
                const x = document.getElementById(id);
                if(x == null)
                    continue;
                if(x.style.display === 'none'){
                    x.style.display = 'block';
                } else {
                    x.style.display = 'none';
                }
            }
        }


    </script>

</div>
