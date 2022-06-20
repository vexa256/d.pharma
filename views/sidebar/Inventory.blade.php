<div class="menu-item active">
    <a class="menu-link active" href="{{ route('NotiFicationsCloud') }}">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-bell" aria-hidden="true"></i>
        </span>
        <span class="menu-title fs-6">Notifications</span>
    </a>
</div>

<div data-kt-menu-trigger="click" class="menu-item viewer_only menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-syringe"
                aria-hidden="true"></i>
        </span>
        <span class="menu-title ms-2 fs-6">Sales</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        MenuItem($link = route('DispenseDrugs'), $label = 'One-time Sale');
        MenuItem($link = route('SelectExistingPatient'), $label = 'Existing Patient Sale');
        
        //MenuItem($link = route('RestockDrugInventory'), $label = 'Insurance Claims');
        
        ?>


    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion viewer_only">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-people-carry"
                aria-hidden="true"></i>
        </span>
        <span class="menu-title ms-2 fs-6">Patient Management</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        MenuItem($link = route('SelectCreditRecoveryTimeFrame'), $label = 'Credit Recovery Report');
        MenuItem($link = route('MgtPatientPackages'), $label = 'Patient Packages');
        MenuItem($link = route('MgtPaymentMethod'), $label = 'Payment Methods');
        MenuItem($link = route('MgtPatients'), $label = 'Patient Records');
        
        MenuItem($link = route('PatientBalanceManagement'), $label = 'Patient Balance Status');
        
        MenuItem($link = route('PatientCreditManagement'), $label = 'Patient Credit Status');
        MenuItem($link = route('NokSelectPatients'), $label = 'Next of Keens');
        
        ?>


    </div>
</div>

@include('sidebar.Staff')

<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-chart-bar"
                aria-hidden="true"></i>
        </span>
        <span class="menu-title ms-2 fs-6">Analytics and Reports</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        MenuItem($link = route('PatientPackageAnalysis'), $label = 'Patient Package Analysis');
        
        MenuItem($link = route('MgtConsInventory'), $label = 'Consumable  Stock Report');
        
        MenuItem($link = route('MgtDrugInventory'), $label = 'Drug  Inventory Report');
        
        MenuItem($link = route('GeneralSalesDateRanger'), $label = 'General Sales Report');
        MenuItem($link = route('StockSalesDateRanger'), $label = 'Stock Sales Analysis');
        
        MenuItem($link = route('StaffSelectDate'), $label = 'Staff Stock Utilization');
        
        // MenuItem($link = route('DateRanger'), $label = 'Creditors Report');
        
        //  MenuItem($link = route('DrugValidity'), $label = 'Drug Validity Report');
        MenuItem($link = route('SelectAnnualRestockYear'), $label = 'Annual Restock Report');
        MenuItem($link = route('SelectMonthlyRestockYear'), $label = 'Monthly Restock Report');
        
        MenuItem($link = route('PatientPurchaseAnalysisSelect'), $label = 'Patient Purchase Analysis');
        // MenuItem($link = route('DateRanger'), $label = 'Profit Analysis Report');
        // MenuItem($link = route('DateRanger'), $label = 'Recorded Loss Report');
        MenuItem($link = route('StockRefundDateRanger'), $label = 'Stock Refund Analysis');
        MenuItem($link = route('DisposalDateRanger'), $label = 'Stock Disposal Analysis');
        // MenuItem($link = route('DateRanger'), $label = 'Patient Package Analysis');
        
        MenuItem($link = route('VendorContractValidity'), $label = 'Vendor Contract Reports');
        
        ?>


    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item viewer_only menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-cogs" aria-hidden="true"></i>
        </span>
        <span class="menu-title ms-2 fs-6">Inventory Settings</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        MenuItem($link = route('MgtDrugCats'), $label = 'Stock Categories');
        MenuItem($link = route('MgtDrugUnits'), $label = 'Quantity Units');
        MenuItem($link = route('MgtDrugVendors'), $label = 'Stock Suppliers');
        MenuItem($link = route('MgtNDA'), $label = 'NDA Drug Database');
        MenuItem($link = route('MgtDrugStore'), $label = 'Supported Drugs');
        
        ?>


    </div>
</div>
<div data-kt-menu-trigger="click" class="menu-item viewer_only menu-accordion">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-boxes"
                aria-hidden="true"></i>
        </span>
        <span class="menu-title ms-2 fs-6">Inventory Operations</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        MenuItem($link = route('MgtSoonExpiring'), $label = 'Soon Expiring Stock');
        MenuItem($link = route('MgtExpiredDrugs'), $label = 'Expired Stock');
        MenuItem($link = route('ReconcileStock'), $label = 'Stock Reconciliation');
        // MenuItem($link = route('MgtNDA'), $label = 'Vendor Contracts');
        //MenuItem($link = route('MgtDrugStore'), $label = 'Supported Drugs');
        ?>


    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion viewer_only">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-box-open"
                aria-hidden="true"></i>
        </span>
        <span class="menu-title ms-2 fs-6">Drug Inventory</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        if (Auth::user()->role != 'viewer') {
            MenuItem($link = route('SelectDrugStockPile'), $label = 'Restock Drugs');
        }
        
        //  MenuItem($link = route('RestockDrugInventory'), $label = 'Restock Drugs');
        // MenuItem($link = route('LowInStockPile'), $label = 'Low in Stock');
        
        // MenuItem($link = route('MgtSoonExpiring'), $label = 'Soon Expiring Stock');
        
        // MenuItem($link = route('MgtExpiredDrugs'), $label = 'Expired Stock');
        
        ?>


    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion viewer_only ">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas text-light fw-bolder fa-2x me-1 fa-tools"
                aria-hidden="true"></i>
        </span>
        <span class="menu-title ms-2 fs-6">Consumables</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        MenuItem($link = route('MgtCons'), $label = 'Consumable Database');
        
        MenuItem($link = route('SelectConsStockPile'), $label = 'Restock Consumable');
        
        MenuItem($link = route('ConsLowInStock'), $label = 'Low in Stock');
        
        //MenuItem($link = route('ConsSoonExpiring'), $label = 'Soon Expiring');
        
        // MenuItem($link = route('MgtExpiredCons'), $label = 'Expired Items');
        
        ?>


    </div>
</div>
