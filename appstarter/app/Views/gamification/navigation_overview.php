<style>
    .circle-container {
        position: relative;
        display: inline-block;
        margin: 20px 15px 45px 15px;
    }

    .circle-container a {
        text-decoration: none;
    }

    .circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
        position: relative;
        transform: rotate(1deg);
    }

    .circle i {
        font-size: 40px;
        color: #333;
        transition: all 0.2s ease-in-out;
    }


    .text {
        font-weight: bold;
        position: absolute;
        /*bottom: -30px;*/
        left: 50%;
        transform: translateX(-50%) rotate(2deg);
        color: #333;
        font-size: 12px;
        opacity: 0;
        transition: all 0.2s ease-in-out;
    }

    .circle-container:hover .circle {
        transform: scale(1.1) rotate(-2deg);
    }

    .circle-container:hover .text {
        opacity: 1;
    }

    .circle-container:hover i {
        opacity: 0.2;
    }

    .navigation-overview-header {
        border-radius: 5px;
    }

</style>


<div class="jumbotron">

    <h1 class="display-4">Navigationsübersicht</h1>
    <p>Zur angenehmeren Navigation auf der Seite.</p>
    <div class="jumbotron jumbotron-fluid navigation-overview-header"
         Style="border-radius: 5px;background-color: #f2dede">
        <div class="container">
            <h2><i class="fa-solid fa-users-between-lines nav-bar-icon"></i> User</h2>
        </div>
    </div>
    <p><i>Hier geht es zu den Formularen für Accounts von Mitarbeitenden und Management.</i></p>
    <div class="circle-container">
        <a href="<?= base_url('/users/show_employees'); ?>">
            <div class="circle">
                <i class="fa-solid fa-clipboard-user"></i>
                <div class="text">Mitarbeitende</div>
            </div>
        </a>
    </div>

    <div class="circle-container">
        <a href="<?= base_url('/users/show_managements') ?>">
            <div class="circle">
                <i class="fa-solid fa-user-tie"></i>
                <div class="text">Management</div>
            </div>
        </a>
    </div>

    <div class="jumbotron jumbotron-fluid navigation-overview-header" Style="background-color: #b2ccda">
        <div class="container">
            <h2><i class="fa-solid fa-folder nav-bar-icon"></i> Formulare P&P</h2>
        </div>
    </div>
    <p><i>Hier geht es zu den Formularen für Personal und Projekte.</i></p>
    <div class="circle-container">
        <a href="<?= base_url('/projects/show_invests') ?>">
            <div class="circle">
                <i class="fa-solid fa-coins"></i>
                <div class="text">Invest</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/projects/show_business_trips') ?>">
            <div class="circle">
                <i class="fa-solid fa-plane-departure"></i>
                <div class="text">Reise</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/projects/show_projects') ?>">
            <div class="circle">
                <i class="fa-solid fa-diagram-project"></i>
                <div class="text">Projekt</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/projects/show_student_assistants') ?>">
            <div class="circle">
                <i class="fa-solid fa-graduation-cap"></i>
                <div class="text">Studentische Hilfskräfte</div>
            </div>
        </a>
    </div>

    <div class="jumbotron jumbotron-fluid navigation-overview-header"
         Style="border-radius: 5px;background-color: #c3e3b5">
        <div class="container">
            <h2><i class="fa-regular fa-pen-to-square nav-bar-icon"></i> Formulare F&L</h2>
        </div>
    </div>
    <p><i>Hier geht es zu den Formularen für Forschung und Lehre inklusive der Journals und Konferenzen.</i></p>
    <div class="circle-container">
        <a href="<?= base_url('/forms/show_publications') ?>">
            <div class="circle">
                <i class="fa-solid fa-file-export"></i>
                <div class="text">Publikationen</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/forms/show_journals_impact') ?>">
            <div class="circle">
                <i class="fa-solid fa-newspaper"></i>
                <div class="text">Journal-Impact</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/forms/show_conferences_impact') ?>">
            <div class="circle">
                <i class="fa-regular fa-building"></i>
                <div class="text">Konferenz-Impact</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/forms/show_teaching_services') ?>">
            <div class="circle">
                <i class="fa-solid fa-person-chalkboard"></i>
                <div class="text">Lehrleistungen</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/forms/show_theses') ?>">
            <div class="circle">
                <i class="fa-solid fa-scroll"></i>
                <div class="text">Abschlussarbeiten</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= $sLinkYoungScientists = base_url('/projects/show_young_scientists') ?>">
            <div class="circle">
                <i class="fa-solid fa-person-arrow-up-from-line"></i>
                <div class="text">Wissenschaftlicher Nachwuchs</div>
            </div>
        </a>
    </div>

    <div class="jumbotron jumbotron-fluid navigation-overview-header" Style="background-color: #ced4da">
        <div class="container">
            <h2><i class="fa-solid fa-sheet-plastic nav-bar-icon"></i> Reports</h2>
        </div>
    </div>
    <p><i>Hier geht es zu den Übersichten über die Daten in Form von Reports.</i></p>
    <div class="circle-container">
        <a href="<?= base_url('/reports/accounts') ?>">
            <div class="circle">
                <i class="fa-solid fa-money-check-dollar"></i>
                <div class="text">Konten</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/reports/project_overview') ?>">
            <div class="circle">
                <i class="fa-solid fa-diagram-project"></i>
                <div class="text">Projektübersicht</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/reports/project') ?>">
            <div class="circle">
                <i class="fa-solid fa-square"></i>
                <div class="text">Einzelprojekt</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/reports/budget_overview') ?>">
            <div class="circle">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <div class="text">Budgetübersicht</div>
            </div>
        </a>
    </div>

    <div class="jumbotron jumbotron-fluid navigation-overview-header" Style="background-color: #ffecb5">
        <div class="container">
            <h2><i class="fa-solid fa-medal nav-bar-icon"></i> Pando</h2>
        </div>
    </div>
    <p><i>Hier geht es zu den Pando-Faktoren und den Pando-Reports.</i></p>
    <div class="circle-container">
        <a href="<?= base_url('/pando/form') ?>">
            <div class="circle">
                <i class="fa-solid fa-file-invoice"></i>
                <div class="text">Formular</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/pando/report') ?>">
            <div class="circle">
                <i class="fa-solid fa-sheet-plastic"></i>
                <div class="text">Report</div>
            </div>
        </a>
    </div>
    <div class="circle-container">
        <a href="<?= base_url('/pando/report_employee') ?>">
            <div class="circle">
                <i class="fa-solid fa-users-rectangle"></i>
                <div class="text">Report Mitarbeitende</div>
            </div>
        </a>
    </div>


    <hr class="my-4">
</div>