<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>

<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json; utf-8',
        }
    });

    $('table').css({ 'width': '100%' });

    // functions
    function getAsync(url, parameters = null, type = 'JSON', beforeSendCallback, successCallback) {
        $.ajax({
            url: url,
            type: 'GET',
            data: parameters,
            dataType: type,
            beforeSend: beforeSendCallback,
            success: successCallback,
            error: (xhr, textStatus, errorThrown) => {
                console.log(xhr);
                $('.modal').modal('hide');
                $('button[type="submit"]').removeAttr('disabled');
                $('button[type="submit"]').html('<i class="fas fa-save"></i>');

                if(xhr.responseJSON) {
                    let errors = "";

                    if(Array.isArray(xhr.responseJSON)) {
                        for(let i = 0; i <= xhr.responseJSON.length; i++) {
                            errors = '<p>'+xhr.responseJSON[i].message+'</p>';
                        }
                    } else {
                        errors = '<p>'+xhr.responseJSON.message+'</p>';
                    }

                    manualToast.fire({
                        icon: 'error',
                        title: 'Error/s had been encountered while processing your request',
                        html: '' +
                            ''+errors+'',
                    });
                } else {
                    manualToast.fire({
                        icon: 'error',
                        title: xhr.status + ' ' + xhr.statusText,
                    });
                }
            }
        });
    }

    function postAsync(url, parameters, type = 'JSON', beforeSendCallback, successCallback) {
        $.ajax({
            url: url,
            type: 'POST',
            data: parameters,
            dataType: type,
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: beforeSendCallback,
            success: successCallback,
            error: (xhr, textStatus, errorThrown) => {
                console.log(xhr);
                $('.modal').modal('hide');
                $('button[type="submit"]').removeAttr('disabled');
                $('button[type="submit"]').html('<i class="fas fa-save"></i>');

                if(xhr.responseJSON) {
                    let errors = "";

                    if(Array.isArray(xhr.responseJSON)) {
                        for(let i = 0; i <= xhr.responseJSON.length; i++) {
                            errors = '<p>'+xhr.responseJSON[i].message+'</p>';
                        }
                    } else {
                        if(xhr.responseJSON.message.includes('SQLSTATE[23000]')) {
                            errors = '<p>Advertiser or Agency should not be <span class="badge badge-danger">Undefined</span></p>';
                        } else {
                            errors = '<p>'+xhr.responseJSON.message+'</p>';
                        }
                    }

                    manualToast.fire({
                        icon: 'error',
                        title: 'Error/s had been encountered while processing your request',
                        html: '' +
                            ''+errors+'',
                    });
                } else {
                    if(xhr.responseText.includes('SQLSTATE[23000]')) {
                        errors = '<p>Advertiser or Agency should not be <span class="badge badge-danger">Undefined</span></p>';

                        manualToast.fire({
                            icon: 'error',
                            title: 'Error/s had been encountered while processing your request',
                            html: '' +
                                ''+errors+'',
                        });
                    } else {
                        manualToast.fire({
                            icon: 'error',
                            title: xhr.status + ' ' + xhr.statusText,
                        });
                    }
                }
            }
        });
    }

    $(document).ready(function() {
        // Initiations
        $('[tooltip]').tooltip();

        $(window).on('keydown', function(event) {
            // Enter key
            if(event.keyCode === 13) {
                $(this).submit();
            }

            // F5 key
            if(event.keyCode === 116) {
                event.preventDefault();
                let path = window.location.pathname;

                // TODO: Refresh the webpage where it was.
                window.location.replace('{{ route('home') }}');

                console.log(path);
            }
        });
    });

    // How the navigation works
    $(document).on('click', 'a[navigation]', function (event) {
        event.preventDefault();
        let navigation = $(this).attr('id');
        let url = $(this).attr('href');

        if(navigation.includes('logs')) {
            getAsync(url, { "logs": navigation }, 'HTML', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                if (navigation === "employees_logs") {
                    document.title = "Employees - Logs";
                    window.history.pushState("", "", '/employees/logs');
                } else if (navigation === "contract_logs") {
                    document.title = "Contracts - Logs";
                    window.history.pushState("", "", '/contracts/logs');
                } else if (navigation === "advertiser_logs") {
                    document.title = "Advertiser - Logs";
                    window.history.pushState("", "", '/advertisers/logs');
                } else if (navigation === "agency_logs") {
                    document.title = "Agency - Logs";
                    window.history.pushState("", "", '/agency/logs');
                } else if (navigation === "sales_logs") {
                    document.title = "Sales - Logs";
                    window.history.pushState("", "", '/sales/logs');
                }

                container = $('#main_content');

                container.fadeOut(500, () => {
                    container.empty();
                    container.fadeIn(500, () => {
                        container.append(result);
                    });
                });
            }
        } else if(navigation.includes('breakdowns')) {
            getAsync(url, { "navigation": navigation }, 'HTML', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                document.title = "Sales Breakdowns";
                window.history.pushState("", "", '/sales/breakdowns');

                container = $('#main_content');

                container.fadeOut(500, () => {
                    container.empty();
                    container.fadeIn(500, () => {
                        container.append(result);
                    });
                });
            }
        } else {
            getAsync(url, { "navigation": "navigation" }, 'HTML', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                if (navigation === 'archives') {
                    document.title = "Compare Contracts";
                    window.history.pushState("", "", '/' + navigation + '/contract');
                } else if (navigation === 'contracts') {
                    document.title = "Contracts - Active"
                    window.history.pushState("", "", '/' + navigation + '/active');
                } else if (navigation === "sales_report") {
                    document.title = "Sales Report"
                    window.history.pushState("", "", '/sales/reports');
                } else if (navigation === "employees") {
                    document.title = "Employees - Accounts"
                    window.history.pushState("", "", '/' + navigation + '/accounts');
                } else if(navigation === "sales") {
                    document.title = "Contract Sales";
                    window.history.pushState("", "", '/contract/sales');
                } else {
                    document.title = navigation.substring(0, 1).toUpperCase() + navigation.substring(1, navigation.length);
                    window.history.pushState("", "", '/' + navigation);
                }

                container = $('#main_content');

                container.fadeOut(500, () => {
                    container.empty();
                    container.fadeIn(500, () => {
                        container.append(result);
                    });
                });
            }
        }
    });

    // how the whole sub navigation in the pages are happening.
    $(document).on('click', 'a[data-action]', function(event) {
        event.preventDefault();

        let action_type = $(this).attr('data-action');

        let url = $(this).attr('data-link');
        let data_id = $(this).attr('data-id');
        let modal = $(this).attr('modal');
        let type = $(this).attr('data-switch');
        let archive_type = $(this).attr('data-compare');
        let contract_type = $(this).attr('data-contract');

        // retrieving data
        if(action_type === 'open') {
            getAsync(url, { "id": data_id, "modal": modal }, 'JSON', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                if(result.employee) {
                    // employee
                    // setting the input fields empty
                    $('#update_first_name, #update_middle_name, #update_last_name, #nickname, #username, #employee_id, #delete-employee-form-body').empty();

                    // setting action urls
                    $('#update-employee-form').attr('action', '{{ url('employees/update') }}' + '/' + result.employee.id);
                    $('#delete-employee-form').attr('action', '{{ url('employees/delete') }}' + '/' + result.employee.id);
                    $('#change-password-form').attr('action', '{{ url('employees/change') }}' + '/' + result.employee.id);

                    // putting the result data in the input fields in update
                    $('#update_first_name').val(result.employee.first_name);
                    $('#update_middle_name').val(result.employee.middle_name);
                    $('#update_last_name').val(result.employee.last_name);
                    $('#update_nickname').val(result.employee.nickname);
                    $('#update_job_id').val(result.employee.job.id);
                    $('#update_username').val(result.employee.username);
                    $('#update_birthdate').val(result.employee.date_of_birth);
                    $('#is_active').val(result.employee.is_active);

                    // putting the employee id in change password modal
                    $('#employee_id, #delete_employee_id').val(result.employee.id);

                    // write a text for confirmation
                    $('#delete-employee-form-body').append('Are you sure to remove <strong>'+result.employee.first_name+' '+result.employee.last_name+'</strong>? All data related to this user will also be deleted and this action is <strong>irreversible</strong>.');
                }

                if(result.advertiser) {
                    // advertiser
                    // setting the input fields empty
                    $('#update_advertiser_name, #delete_advertiser_id').empty();

                    // setting action urls
                    $('#update-advertiser-form').attr('action', '{{ url('advertisers/update') }}' + '/' + result.advertiser.advertiser_code);
                    $('#delete-advertiser-form').attr('action', '{{ url('advertisers/delete') }}' + '/' + result.advertiser.advertiser_code);

                    // putting the result data in the input fields in update
                    $('#update_advertiser_name').val(result.advertiser.advertiser_name);
                    $('#is_active').val(result.advertiser.is_active);

                    // writing a text for confirmation
                    $('#delete-employee-form-body').append('Are you sure to delete <strong>'+result.advertiser.advertiser_name+'</strong>? All data related to this advertiser will also be deleted and this action is <strong>irreversible</strong>.');
                }

                if(result.agency) {
                    // agency
                    // setting the input fields empty
                    $('#update_agency_name, #update_address, #update_contact_number, #delete_agency_id, #delete-agency-form-body').empty();

                    // setting action urls
                    $('#update-agency-form').attr('action', '{{ url('agencies/update') }}' + '/' + result.agency.agency_code);
                    $('#delete-agency-form').attr('action', '{{ url('agencies/delete') }}' + '/' + result.agency.agency_code);

                    // putting the result data in the input fields in update
                    $('#update_agency_name').val(result.agency.agency_name);
                    $('#update_address').val(result.agency.address);
                    $('#update_contact_number').val(result.agency.contact_number);
                    $('#update_kbp_accredited').val(result.agency.kbp_accredited);
                    $('#is_active').val(result.agency.is_active);

                    // writing a text for confirmation
                    $('#delete-agency-form-body').append('Are you sure to delete <strong>'+result.agency.agency_name+'</strong>? All data related to this agency will also be deleted and this action is <strong>irreversible</strong>.');
                }

                if(result.contract) {
                    // contract
                    $('#delete-contract-form-body, #contract-status-title, #contract-status-form-body, #contract-status-button, #bo_number, #bo_number_text, #package_cost, #package_cost_vat, #package_cost_salesdc, #prod_cost, #prod_cost_vat, #prod_cost_salesdc').empty();

                    // setting action urls
                    $('#delete-contract-form').attr('action', '{{ url('contracts/delete') }}' + '/' + result.contract.id);
                    $('#contract-status-form').attr('action', '{{ url('contracts/update') }}' + '/' + result.contract.id);

                    if(result.contract.is_active === 1) {
                        $('#contract-status-title').text('Deactivate Contract?');
                        $('#contract-status-form-body').html('Are you sure to deactivate the contract with the contract number of ' + result.contract.contract_number + '?');
                        $('#contract-status-button').text('Deactivate');
                    }

                    if(result.contract.is_active === 0) {
                        $('#contract-status-title').text('Reactivate Contract?');
                        $('#contract-status-form-body').html('Are you sure to reactivate the contract with the contract number of ' + result.contract.contract_number + '?')
                        $('#contract-status-button').text('Reactivate');
                    }

                    // for adding Sales Breakdown
                    $('#contract_id').val(result.contract.id);
                    $('#bo_number_text').text(result.contract.bo_number);
                    $('#bo_number').val(result.contract.bo_number);
                    $('#package_cost').val(result.contract.package_cost);
                    $('#package_cost_vat').val(result.contract.package_cost_vat);
                    $('#package_cost_salesdc').val(result.contract.package_cost_salesdc);

                    $('#bo_type').val(result.contract.bo_type);
                    $('#agency_id').val(result.contract.agency_id);
                    $('#advertiser_id').val(result.contract.advertiser_id);
                    $('#employee_id').val(result.contract.ae);

                    $('#prod_cost').val(result.contract.prod_cost);
                    $('#prod_cost_vat').val(result.contract.prod_cost_vat);
                    $('#prod_cost_salesdc').val(result.contract.prod_cost_salesdc);

                    // writing a text for confirmation
                    $('#delete-contract-form-body').append('Are you sure to delete the contract <strong>'+result.contract.bo_number+'</strong>? All data related to this contract will also be deleted and this action is <strong>irreversible</strong>.');
                }

                if(result.job) {
                    // job
                    $('#job_description, #level, #is_active, #delete-job-form-body').empty();

                    // setting action urls
                    $('#update-job-form').attr('action', '{{ url('jobs/update') }}' + '/' + result.job.id);
                    $('#delete-job-form').attr('action', '{{ url('jobs/delete') }}' + '/' + result.job.id);

                    // putting the result data in the input fields in update
                    $('#update_job_description').val(result.job.job_description);
                    $('#update_level').val(result.job.level);
                    $('#update_is_active').val(result.job.is_active);

                    // writing a text for confirmation
                    $('#delete-job-form-body').append('Are you sure to delete the job description <strong>'+result.job.job_description+'</strong>? All data related to this job description will also be deleted and this action is <strong>irreversible</strong>.');
                }

                if(result.sale) {
                    $('#invoice_no, #bo_number, #sale_year, #sale_amount').empty();

                    // setting action urls
                    $('#update-invoice-form, #update-sales-form').attr('action', '{{ url('sales/update') }}' + '/' + result.sale.id);

                    // putting the result data in the input fields in update
                    $('#bo_number_text').text(result.sale.contract.bo_number);
                    $('#invoice_no').val(result.sale.invoice_no);
                    $('#bo_number').val(result.sale.contract.bo_number);
                    $('#bo_type').val(result.sale.contract.bo_type);
                    $('#station').val(result.sale.station);
                    $('#type').val(result.sale.type);
                    $('#amount_type').val(result.sale.amount_type)
                    $('#month').val(result.sale.month);
                    $('#year').val(result.sale.year);
                    $('#sale_amount').val(result.sale.amount);
                    $('#sale_gross_amount').val(result.sale.gross_amount);

                    // for updating Sales Breakdown
                    $('#package_cost').val(result.sale.contract.package_cost);
                    $('#package_cost_vat').val(result.sale.contract.package_cost_vat);
                    $('#package_cost_salesdc').val(result.sale.contract.package_cost_salesdc);

                    $('#prod_cost').val(result.sale.contract.prod_cost);
                    $('#prod_cost_vat').val(result.sale.contract.prod_cost_vat);
                    $('#prod_cost_salesdc').val(result.sale.contract.prod_cost_salesdc);
                }
            }
        }
        // creating a new contract
        if(action_type === 'create') {
            getAsync(url, null, 'HTML', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                document.title = 'New Contract';
                window.history.pushState("", "", '/contracts/new');

                $('#main_content').fadeOut(500, () => {
                    $('#main_content').empty();
                    $('#main_content').fadeIn(500, () => {
                        $('#main_content').append(result);
                    });
                });
            }
        }
        // viewing contracts and sales
        if(action_type === 'view') {
            getAsync(url, { "id": data_id }, 'HTML', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading Contract ...',
                });
            }

            function onSuccess(result) {
                manualToast.close();
                document.title = 'View Contract';
                window.history.pushState("", "View Contract", '/contracts/show/'+data_id);

                $('#main_content').fadeOut(500, () => {
                    $('#main_content').empty();
                    $('#main_content').fadeIn(500, () => {
                        $('#main_content').append(result);
                        Toast.fire({
                            icon: 'success',
                            title: 'Contract has been loaded',
                        });
                    });
                });
            }
        }
        // switching
        if(action_type === 'switch') {
            if(contract_type === 'child_inactive') {
                getAsync(url, { "action": action_type, "switch": type, "child_bo": "inactive" }, 'HTML', beforeSend, onSuccess);

                function beforeSend() {
                    manualToast.fire({
                        icon: 'info',
                        title: 'Loading ...'
                    });
                }

                function onSuccess(result) {
                    manualToast.close();
                    if(url.includes('sales')) {
                        document.title = "Contract Sales - Non-Active Child BO";
                        window.history.pushState("", "", '/sales/contracts/bo/child/non-active');

                        $('#main_content').fadeOut(500, () => {
                            $('#main_content').empty();
                            $('#main_content').fadeIn(500, () => {
                                $('#main_content').append(result);
                            });
                        });
                    } else {
                        document.title = "Contracts - Non-Active Child BO";
                        window.history.pushState("", "", '/contracts/bo/child/non-active');

                        $('#main_content').fadeOut(500, () => {
                            $('#main_content').empty();
                            $('#main_content').fadeIn(500, () => {
                                $('#main_content').append(result);
                            });
                        });
                    }
                }
            } else {
                getAsync(url, { "action": action_type, "switch": type }, 'HTML', beforeSend, onSuccess);

                function beforeSend() {
                    manualToast.fire({
                        icon: 'info',
                        title: 'Loading ...'
                    });
                }

                function onSuccess(result) {
                    manualToast.close();
                    if(url.includes('sales')) {
                        if(type === 'parent') {
                            document.title = 'Contract Sales - Parent BO';
                            window.history.pushState("", "", '/sales/contracts/bo/parent');
                        }

                        if(type === 'inactive_parent') {
                            document.title = 'Contract Sales - Inactive Parent BO';
                            window.history.pushState("", "", '/sales/contracts/bo/parent/inactive');
                        }

                        if(type === 'child_bo') {
                            document.title = 'Contract Sales - Child BO';
                            window.history.pushState("", "", '/sales/contracts/bo/child');
                        }

                        if(type === 'inactive') {
                            document.title = 'Contract Sales - Inactive';
                            window.history.pushState("", "", '/sales/contracts/inactive');
                        }

                        if(type === 'inactive_child_bo') {
                            document.title = "Contract Sales - Non-Active Child BO";
                            window.history.pushState("", "", '/sales/contracts/bo/child/non-active');
                        }
                    } else {
                        if(type === 'inactive') {
                            document.title = 'Contracts - Inactive';
                            window.history.pushState("", "", '/contracts/inactive');
                        }

                        if(type === 'child_bo') {
                            document.title = 'Contracts - Child BO';
                            window.history.pushState("", "", '/contracts/bo/child');
                        }

                        if(type === 'inactive_child_bo') {
                            document.title = "Contracts - Non-Active Child BO";
                            window.history.pushState("", "", '/contracts/bo/child/non-active');
                        }

                        if(type === 'parent') {
                            document.title = 'Contracts - Parent BO';
                            window.history.pushState("", "", '/contracts/bo/parent');
                        }

                        if(type === 'inactive_parent') {
                            document.title = 'Contracts - Inactive Parent BO';
                            window.history.pushState("", "", '/contracts/bo/parent/non-active');
                        }
                    }

                    if(type === 'monthly') {
                        document.title = 'Sales Report - Monthly View';
                        window.history.pushState("", "", '/sales/monthly');
                    }

                    if(type === 'executive') {
                        document.title = 'Sales Report - Executives View';
                        window.history.pushState("", "", '/sales/executives');
                    }

                    if (type === 'sales') {
                        document.title = 'Compare Sales';
                        window.history.pushState("", "", '/archives/sale');
                    }

                    $('#main_content').fadeOut(500, () => {
                        $('#main_content').empty();
                        $('#main_content').fadeIn(500, () => {
                            $('#main_content').append(result);
                        });
                    });
                }
            }
        }
        // for comparing the contracts and sales
        if(action_type === 'compare') {
            getAsync(url, { "type": archive_type }, "HTML", beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                archive_type = document.title = archive_type.substring(0, 1).toUpperCase() + archive_type.substring(1, archive_type.length);

                Toast.fire({
                    icon: 'success',
                    title: archive_type + ' has been loaded!'
                });

                if(archive_type === 'Contract') {
                    compare_container = $('#compare-modal-body');
                } else {
                    compare_container = $('#compare-sales-modal-body');
                }

                compare_container.empty();
                compare_container.append(result);
            }
        }
        // for viewing the sales breakdown
        if(action_type === 'breakdown') {
            getAsync(url, { "bo_number": data_id, "view": action_type }, "HTML", beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading Breakdowns ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                document.title = 'Sales Breakdown Id: ' + data_id;
                window.history.pushState("", "", '/sales/show/breakdowns/' + data_id);

                $('#main_content').fadeOut(500, () => {
                    $('#main_content').empty();
                    $('#main_content').fadeIn(500, () => {
                        $('#main_content').append(result);
                    });
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Breakdowns for '+ data_id + ' has been loaded'
                });
            }
        }
    });

    // more scripts
    // focus on the first input or select field.
    $(document).on('shown.bs.modal', function () {
        $(this).find('input[type="text"]').first().focus() ?
            $(this).find('input[type="text"]').first().focus() : $(this).find('input[type="password"]').first().focus() ?
            $(this).find('input[type="password"]').first().focus() : $(this).find('select').first().focus();
    });

    $(document).on('change', '#sort_by', function () {
        let sort_by = $(this).val();

        if(!sort_by) {
            $('#month_row').attr('hidden', 'hidden');
            $('#year_row').attr('hidden', 'hidden');
            $('#quarter_row').attr('hidden', 'hidden');
        } else if(sort_by === 'month') {
            $('#month_row').removeAttr('hidden');
            $('#year_row').attr('hidden', 'hidden');
            $('#quarter_row').attr('hidden', 'hidden');
        } else if(sort_by === 'quarter') {
            $('#month_row').attr('hidden', 'hidden');
            $('#year_row').attr('hidden', 'hidden');
            $('#quarter_row').removeAttr('hidden');
        } else if(sort_by === 'year') {
            $('#month_row').attr('hidden', 'hidden');
            $('#year_row').removeAttr('hidden');
            $('#quarter_row').attr('hidden', 'hidden');
        }
    });

    $(document).on('click', 'input[type="checkbox"]', function() {
        let checkbox = $(this);
        let location = checkbox.attr('id');

        if(checkbox.is(':checked')) {
            if(location === 'Manila') {
                $('#manila_cash, #manila_ex, #manila_prod').removeAttr('readonly');
            }

            if(location === 'Cebu') {
                $('#cebu_cash, #cebu_ex, #cebu_prod').removeAttr('readonly');
            }

            if(location === 'Davao') {
                $('#davao_cash, #davao_ex, #davao_prod').removeAttr('readonly');
            }
        } else {
            if(location === 'Manila') {
                $('#manila_cash, #manila_ex, #manila_prod').attr('readonly', true);
            }

            if(location === 'Cebu') {
                $('#cebu_cash, #cebu_ex, #cebu_prod').attr('readonly', true);
            }

            if(location === 'Davao') {
                $('#davao_cash, #davao_ex, #davao_prod').attr('readonly', true);
            }
        }
    });

    // for getting the total amount and total prod
    $(document).on('keyup', '#manila_cash, #cebu_cash, #davao_cash, #manila_ex, #cebu_ex, #davao_ex, #manila_prod, #cebu_prod, #davao_prod', function() {
        findTotal();
    });

    function findTotal() {
        gross = $('#gross');
        net = $('#net');
        vatinc = $('#vatinc');
        nonvat = $('#nonvat');

        prodgross = $('#prod_gross');
        prodnet = $('#prod_net');
        prodvatinc = $('#prod_vat_inc');
        prodnonvat = $('#prod_non_vat');

        manilacash = $('#manila_cash').val() || 0.00;
        cebucash = $('#cebu_cash').val() || 0.00;
        davaocash = $('#davao_cash').val() || 0.00;

        manilaex = $('#manila_ex').val() || 0.00;
        cebuex = $('#cebu_ex').val() || 0.00;
        davaoex = $('#davao_ex').val() || 0.00;

        manilacash = parseFloat(manilacash);
        cebucash = parseFloat(cebucash);
        davaocash = parseFloat(davaocash);

        manilaex = parseFloat(manilaex);
        cebuex = parseFloat(cebuex);
        davaoex = parseFloat(davaoex);


        if(gross.prop("checked") || net.prop("checked") || vatinc.prop("checked") || nonvat.prop("checked")) {
            //
        } else {
            totalcash =  manilacash+ cebucash + davaocash;
            totalex = manilaex + cebuex + davaoex;
            totalamount = totalcash + totalex;

            $('#total_cash').val(totalcash);
            $('#total_ex').val(totalex);

            $('#total_amount').val(totalamount);
        }

        // Prod
        manilaprod = $('#manila_prod').val() || 0.00;
        cebuprod = $('#cebu_prod').val() || 0.00;
        davaoprod = $('#davao_prod').val() || 0.00;

        if(prodgross.prop("checked") || prodnet.prop("checked") || prodvatinc.prop("checked") || prodnonvat.prop("checked")) {
            //
        } else {
            manilaprod = parseFloat(manilaprod);
            cebuprod = parseFloat(cebuprod);
            davaoprod = parseFloat(davaoprod);

            totalprod = manilaprod + cebuprod + davaoprod;

            $('#total_prod').val(totalprod);
        }

    }

    function findSalesTotal() {
        type = $('#type').val();
        amount = $('#sale_amount').val();

        amount = parseFloat(amount);

        if(type == 'airtime' || type == 'spots' || type == 'live' || type == 'DJDisc' || type == 'top10' || type === 'Spots')
        {
            typecost = $('#package_cost').val();
            typecost_vat = $('#package_cost_vat').val();
            typecost_salesdc = $('#package_cost_salesdc').val();

        } else if (type == 'totalprod') {
            typecost = $('#prod_cost').val();
            typecost_vat = $('#prod_cost_vat').val();
            typecost_salesdc = $('#prod_cost_salesdc').val();
        }

        if(typecost == 'Package Cost(NET)' || typecost == 'Production Cost(NET)')
        {
            //NET
            gross = amount / .85;
            gross = Math.round((gross) * 100) / 100;
        } else if(typecost == 'Package Cost(GROSS)' || typecost == 'Production Cost(GROSS)') {
            //GROSS
            gross = amount;
            gross = Math.round((gross) * 100) / 100;
        }

        $('#sale_gross_amount').val(gross);

        // NET/GROSS AND VATINC
        if(typecost_vat == 'VATINC')
        {
            gross = gross/1.12;
            gross = Math.round((gross) * 100) / 100;

            $('#sale_gross_amount').val(gross);
            // NET/GROSS AND VAT INC AND DISC
            if(typecost_salesdc !== 0)
            {
                gross = gross / ((100 - typecost_salesdc)/100);
                gross = Math.round((gross) * 100) / 100;
                $('#sale_gross_amount').val(gross);
            }
        }
        // NET/GROSS AND SALES DISC
        else if (typecost_salesdc !== 0)
        {
            gross = gross / ((100 - typecost_salesdc)/100);
            gross = Math.round((gross) * 100) / 100;

            $('#sale_gross_amount').val(gross);
        }
    }
    //end

    // reset buttons
    $(document).on('click', '#reset_cash', function(event) {
        event.preventDefault();
        $('#manila_cash, #manila_ex, #cebu_cash, #cebu_ex, #davao_cash, #davao_ex, #total_amount, #total_cash, #total_ex, #package_cost_salesdc').val('0.00');
        $('#gross, #net, #nonvat, #vatex, #vatinc').prop('checked', false);
    });

    $(document).on('click', '#reset_prod', function(event) {
        event.preventDefault();
        $('#manila_prod, #cebu_prod, #davao_prod, #total_prod, #prod_cost_salesdc').val('0.00');
        $('#prod_gross, #prod_net, #prod_non_vat, #prod_vat_ex, #prod_vat_inc').prop('checked', false);
    });

    // adding the details
    $(document).on('change', '#template, #template1, #template2, #template3, #template4, #template5, #template6, #template7', function() {
        key = $(this).attr('id');

        value = $( '#'+key+' option:selected' ).text();

        detail = $('#detail').val();
        $('#detail').val(detail + " " + value);

        $(this).prop('selectedIndex',0);
    });

    // form functions
    $(document).on('submit', '#sort_form', function (event) {
        event.preventDefault();

        let url = $(this).attr('action');
        let executive = $('#ae').val();
        let station = $('#station').val();
        let agency = $('#agency').val();
        let agency_name = $('#agency option:selected').text();
        let advertiser = $('#advertiser').val();
        let advertiser_name = $('#advertiser option:selected').text();
        let month = $('#month').val();
        let mo_year = $('#month_year').val();
        let quarter = $('#quarter').val();
        let qr_year = $('#quarter_year').val();
        let year = $('#year').val();

        if(!executive && !station && !agency && !advertiser && !month && !quarter && !year && !mo_year && !qr_year) {
            getAsync(url, { "sort": "all" }, 'HTML', beforeSend, onSuccess);

            function beforeSend() {
            $('button[type="submit"]').attr('disabled', 'disabled');
                $('#sort-modal').modal('hide');
                manualToast.fire({
                    icon: 'info',
                    title: 'Loading All Sales ...',
                })
            }

            function onSuccess(result) {
            $('button[type="submit"]').removeAttr('disabled');
                $('#main_content').fadeOut(500, () => {
                    $('#main_content').empty();
                    $('#main_content').fadeIn(500, () => {
                        $('#main_content').append(result);
                    });
                });

                Toast.fire({
                    icon: 'success',
                    title: 'All Time Sales have been loaded'
                });
            }
        } else {
            getAsync(url, { "sort": { "employee_id": executive, "station": station, "agency_id": agency, "agency_name": agency_name, "advertiser_id": advertiser, "advertiser_name": advertiser_name, "month": month, "mo_year": mo_year ,"quarter": quarter, "qr_year": qr_year, "year": year } }, 'HTML', beforeSend, onSuccess);

            function beforeSend() {
                $('#sort-modal').modal('hide');
                manualToast.fire({
                    icon: 'info',
                    title: 'Sorting Sales ...',
                })
            }

            function onSuccess(result) {
                manualToast.close();
                $('#main_content').fadeOut(500, () => {
                    $('#main_content').empty();
                    $('#main_content').fadeIn(500, () => {
                        $('#main_content').append(result);
                    });
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Sales has been sorted'
                });
            }
        }
    });

    $(document).on('change', '#agency_id', function(event) {
        let url = '{{ route('agencies.show') }}';
        let data_id = $(this).val();

        getAsync(url, { "kbp_verification": "kbp_verification", "id": data_id }, 'JSON', beforeSend, onSuccess);

        function beforeSend() {

        }

        function onSuccess(result) {
            $('#kbp_accreditation').empty();
            $('#kbp_accreditation').append(result.agency.kbp_status);
        }
    });

    // creating and updating the contract
    $(document).on('submit', '#add-contract-form, #update-contract-form', function(event) {
        event.preventDefault();

        let url = $(this).attr('action');
        let home_url = '{{ route('contracts') }}';
        let formData = new FormData(this);
        let formType = $(this).attr('data-form');
        let requestType = $(this).attr('data-request');

        postAsync(url, formData, 'HTML' ? 'HTML' : 'JSON', beforeSend, onSuccess);

        function beforeSend() {
            $('button[type="submit"]').attr('disabled', 'disabled');
        }

        function onSuccess(result) {
            $('button[type="submit"]').removeAttr('disabled');

            if(requestType == "update") {
                getAsync(home_url, { 'navigation': 'navigation' }, 'HTML', beforeSend, onSuccess);

                function beforeSend() {

                }

                function onSuccess(result) {
                    $('#main_content').fadeOut(500, () => {
                        $('#main_content').empty();
                        $('#main_content').fadeIn(500, () => {
                            $('#main_content').append(result);
                        });
                    });

                    Toast.fire({
                        icon: 'success',
                        title: formType+' has been updated!'
                    });
                }
            } else {
                getAsync(home_url, { 'navigation': 'navigation' }, 'HTML', beforeSend, onSuccess);

                function beforeSend() {

                }

                function onSuccess(result) {
                    $('#main_content').fadeOut(500, () => {
                        $('#main_content').empty();
                        $('#main_content').fadeIn(500, () => {
                            $('#main_content').append(result);
                        });
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'A new '+formType+' has been saved!'
                    });
                }
            }
        }
    });

    // for toggling in the my job tab
    $(document).on('click', '.nav-pills > .nav-item > a.nav-link', function() {
        $('.nav-pills > .nav-item > a.nav-link.active').removeClass('active');
        $(this).addClass('active');
    });

    // for collapse in the my job tab
    $(document).on('click', 'a[data-toggle="collapse"]', function() {
        let button = $(this).attr('href');

        $('.collapse.show').collapse('hide');
        $('a'+button+'').addClass('show');
    });

    // show/hide parent_bo field
    $(document).on('change', '#bo_type', function() {
        let select_parent_bo = $('#select_parent_bo');
        let parent_bo = $('#parent_bo');
        let type = $(this).val();

        if(type == "child") {
            select_parent_bo.removeAttr('hidden');
            parent_bo.removeAttr('disabled');
        } else {
            select_parent_bo.prop('hidden', 'hidden');
            parent_bo.prop('disabled', 'disabled');
        }
    });

    // verify if the agency or advertiser name is already existing
    $(document).on('change', '#agency_name, #advertiser_name', function() {
        let selector = $(this).attr('id');
        let selector_value = $(this).val();

        if(selector.includes('agency')) {
            getAsync('{{ route('agencies') }}', { "search": "search", "value": selector_value }, 'JSON', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Checking if agency is existing ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                if(result.status === "non-existing") {
                    $('button[type="submit"]').removeAttr('disabled');

                    Toast.fire({
                        icon: 'success',
                        title: 'No existing agency with the name of ' + selector_value
                    });

                    $('.modal').on('hide.bs.modal', function() {
                        $('#agency_name, #address, #contact_number').val('');
                        $('button[type="submit"]').removeAttr('disabled');
                    });
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Existing agency with the name of ' + selector_value + ' has been found'
                    });

                    $('#agency_name, #address, #contact_number').val('');

                    $('#agency_name').val(result.agency_name);
                    $('#address').val(result.address);
                    $('#contact_number').val(result.contact_number);
                    $('#kbp_accredited').val(result.kbp_accredited);

                    $('button[type="submit"]').prop('disabled', 'disabled');

                    $('.modal').on('hide.bs.modal', function() {
                        $('#agency_name, #address, #contact_number').val('');
                        $('button[type="submit"]').removeAttr('disabled');
                    });
                }
            }
        } else {
            getAsync('{{ route('advertisers') }}', { "search": "search", "value": selector_value }, 'JSON', beforeSend, onSuccess);

            function beforeSend() {
                manualToast.fire({
                    icon: 'info',
                    title: 'Checking if advertiser is existing ...'
                });
            }

            function onSuccess(result) {
                manualToast.close();
                if(result.status === "non-existing") {
                    $('button[type="submit"]').removeAttr('disabled');

                    Toast.fire({
                        icon: 'success',
                        title: 'No existing advertiser with the name of ' + selector_value
                    });

                    $('.modal').on('hide.bs.modal', function() {
                        $('#advertiser_name').val('');
                        $('button[type="submit"]').removeAttr('disabled');
                    });
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Existing advertiser with the name of ' + selector_value + ' has been found'
                    });

                    $('#advertiser_name').val('');

                    $('#advertiser_name').val(result.advertiser_name);

                    $('button[type="submit"]').prop('disabled', 'disabled');

                    $('.modal').on('hide.bs.modal', function() {
                        $('#advertiser_name').val('');
                        $('button[type="submit"]').removeAttr('disabled');
                    });
                }
            }
        }
    });
</script>
