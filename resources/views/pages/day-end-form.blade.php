<x-app-layout>
    <div class="pagetitle">
        <h1>BC Day End Report</h1>
    </div>
    <section class="section daily-activity">
        <div class="mx-0 px-2 px-sm-3 px-md-4 pb-5">
            <form id="transactionForm">
                <!-- Transaction Details -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Transactions processed :-</h5>
                    </div>
                    <div class="card-body p-3 ps-md-4 pb-md-5 pe-md-4 pb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">AEPS Deposits</label>
                                <div class="input-group">
                                    <input type="text" class="form-control count" name="aeps_deposit_count"
                                        placeholder="Count">
                                    <input type="text" class="form-control amount" name="aeps_deposit_amount"
                                        placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">AEPS Withdrawals</label>
                                <div class="input-group">
                                    <input type="text" class="form-control count" name="aeps_withdrawal_count"
                                        placeholder="Count">
                                    <input type="text" class="form-control amount" name="aeps_withdrawal_amount"
                                        placeholder="Amount">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
    
                            <div class="col-md-6">
                                <label class="form-label">Rupay(Card) Withdrawals</label>
                                <div class="input-group">
                                    <input type="text" class="form-control count" name="rupay_withdrawal_count"
                                        placeholder="Count">
                                    <input type="text" class="form-control amount" name="rupay_withdrawal_amount"
                                        placeholder="Amount">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">SHG Transaction</label>
                                <div class="input-group">
                                    <input type="text" class="form-control count" name="shg_count"
                                        placeholder="Count">
                                    <input type="text" class="form-control amount" name="shg_amount"
                                        placeholder="Amount">
                                </div>
                            </div>

                        </div>


                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label">Fund Transfers</label>
                                <div class="input-group">
                                    <input type="text" class="form-control count" name="fund_transfer_count"
                                        placeholder="Count">
                                    <input type="text" class="form-control amount" name="fund_transfer_amount"
                                        placeholder="Amount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">TPD Transaction</label>
                                <div class="input-group">
                                    <input type="text" class="form-control count" name="tpd_count"
                                        placeholder="Count">
                                    <input type="text" class="form-control amount" name="tpd_amount"
                                        placeholder="Amount">
                                </div>
                                {{-- <input type="text" class="form-control mt-2" name="other_details"
                                    placeholder="Enter details"> --}}
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Other Transaction</label>
                                <div class="input-group">
                                    <input type="text" class="form-control count" name="other_count"
                                        placeholder="Count">
                                    <input type="text" class="form-control amount" name="other_amount"
                                        placeholder="Amount">
                                </div>
                                {{-- <input type="text" class="form-control mt-2" name="other_details"
                                    placeholder="Enter details"> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enrollment Details -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Enrolment Processed :-</h5>
                    </div>
                    <div class="card-body p-3 ps-md-4 pb-md-5 pe-md-4 pb-4">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">PMJDY</label>
                                <input type="text" class="form-control count" name="pmjdy_count" placeholder="Enter count">
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">PMJJBY</label>
                                <input type="text" class="form-control count" name="pmjjby_count" placeholder="Enter count">
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">PMSBY</label>
                                <input type="text" class="form-control count" name="pmsby_count" placeholder="Enter count">
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">RD</label>
                                <input type="text" class="form-control count" name="rd_count" placeholder="Enter count">
                            </div>
                        </div>
                    
                        <div class="row g-3 mt-1">
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">FD</label>
                                <input type="text" class="form-control count" name="fd_count" placeholder="Enter count">
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">APY</label>
                                <input type="text" class="form-control count" name="apy_count" placeholder="Enter count">
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">SB Account</label>
                                <input type="text" class="form-control count" name="sb_count" placeholder="Enter count">
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <label class="form-label">e-KYC Processed</label>
                                <input type="text" class="form-control count" name="ekyc_processed" placeholder="Enter count">
                            </div>
                        </div>
                    
                        
                        {{-- <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Recurring/Fixed Deposit Accounts</label>
                                <input type="text" class="form-control count" name="deposit_accounts"
                                    placeholder="Enter count">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PMSBY</label>
                                <input type="text" class="form-control count" name="aadhaar_seeding"
                                    placeholder="Enter count">
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">e-KYC Processed</label>
                                <input type="text" class="form-control count" name="ekyc_processed"
                                    placeholder="Enter count">
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Device Issues -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Other Details</h5>
                    </div>
                    <div class="card-body p-3 ps-md-4 pb-md-5 pe-md-4 pb-4">
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Total Amount Deposited in bank</label>
                                <input type="text" class="form-control count" name="deposited_amount_bank" placeholder="End of the day bank deposit">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Closing Cash Balance</label>
                                <input type="text" class="form-control count" name="closing_cash" placeholder="CIH after completing the day's operations">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Pending Transactions(if Any)</label>
                                <input type="text" class="form-control count" name="pending_transaction_count" placeholder="Count of unresolved or failed transaction">
                            </div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Challenges faced during the day</label>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select Challenges
                                    </button>
                                    <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                                        <li><input type="checkbox" name="challenges[]" value="Network Issue"> Network Issue</li>
                                        <li><input type="checkbox" name="challenges[]" value="System Crash"> System Crash</li>
                                        <li><input type="checkbox" name="challenges[]" value="Power Failure"> Power Failure</li>
                                        <li><input type="checkbox" name="challenges[]" value="Customer Complaint"> Customer Complaint</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Logout status</label>
                                <select class="form-control" name="logout_status" id="logout_status">
                                    <option value="success">Success</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label" for="device_issues">POS/Device Issues</label>
                                <select class="form-control" name="device_issues" id="device_issues">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="row g-3 align-items-center mt-1">
                            <div class="col-lg-6" id="issue_details_wrapper" style="display: none;">
                                <label class="form-label" for="issue_details">Issue Details</label>
                                <textarea class="form-control" name="issue_details" id="device_issue_details" placeholder="Enter details" rows="3"></textarea>
                            </div>
                            <div class="col-lg-6" id="remarks_wrapper">
                                <label class="form-label" for="remarks">Remarks:</label>
                                <textarea class="form-control" name="remarks" id="remarks" placeholder="Final comments" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg px-5" id="submitButton">
                        <span id="buttonText">Submit</span>
                        <div id="loadingSpinner" class="spinner-border spinner-border-sm text-light ms-2" 
                            role="status" style="display:none;">
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
            width: 1400 px;
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
        }

        .form-label {
            font-weight: 600;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .input-group .form-control {
            flex: 1;
        }

        .btn-success {
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>


    {{-- <script>
        $(document).ready(function() {
            // Show/Hide issue details based on dropdown selection
            $('#device_issues').on('change', function() {
                if (this.value === 'Yes') {
                    $('#issue_details_wrapper').css('display', 'block');
                } else {
                    $('#issue_details_wrapper').css('display', 'none');
                }
            });

            function validateFields(scrollToError = false) {
                let isValid = true;
                $('.is-invalid').removeClass('is-invalid');
                $('.error-message').remove();
                let firstInvalidField = null;

                // Validate each Class Count field
                $(".count").each(function() {
                    let classCount = $(this).val();
                    if (!/^\d+$/.test(classCount) || parseInt(classCount) <= 0) {
                        $(this).addClass("is-invalid");
                        $(this).after(
                            '<div class="error-message text-danger">Please enter a valid count (positive integer).</div>'
                        );
                        isValid = false;
                        if (!firstInvalidField) firstInvalidField = $(this);
                    }
                });

                // Validate each Amount field
                $(".amount").each(function() {
                    let amount = $(this).val();
                    if (!/^\d+(\.\d{1,2})?$/.test(amount) || parseFloat(amount) <= 0) {
                        $(this).addClass("is-invalid");
                        $(this).after(
                            '<div class="error-message text-danger">Please enter a valid amount (positive number with up to 2 decimal places).</div>'
                        );
                        isValid = false;
                        if (!firstInvalidField) firstInvalidField = $(this);
                    }
                });

                // Scroll to first invalid field ONLY on form submit
                if (scrollToError && firstInvalidField) {
                    $('html, body').animate({
                        scrollTop: firstInvalidField.offset().top - 80
                    }, 500);
                }

                return isValid;
            }

            // Prevent invalid input in Class Count (only numbers allowed)
            $(document).on("keypress", ".count", function(e) {
                let keyCode = e.which ? e.which : e.keyCode;
                if (keyCode < 48 || keyCode > 57) {
                    e.preventDefault(); // Block non-numeric input
                }
            });

            // Prevent invalid input in Amount (only numbers and one decimal allowed)
            $(document).on("keypress", ".amount", function(e) {
                let keyCode = e.which ? e.which : e.keyCode;
                let currentValue = $(this).val();

                // Allow numbers (48-57), one dot (46) if not already present
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
                    e.preventDefault();
                }
                if (keyCode === 46 && currentValue.includes(".")) {
                    e.preventDefault(); // Prevent more than one decimal
                }
            });

            // Prevent pasting invalid values
            $(document).on("paste", ".count, .amount", function(e) {
                let pastedData = e.originalEvent.clipboardData.getData("text");
                if ($(this).hasClass("count") && !/^\d+$/.test(pastedData)) {
                    e.preventDefault();
                }
                if ($(this).hasClass("amount") && !/^\d+(\.\d{1,2})?$/.test(pastedData)) {
                    e.preventDefault();
                }
            });

            // Validate fields on input change but DON'T scroll
            $(document).on("input", ".count, .amount", function() {
                validateFields(false);
            });

            $('#transactionForm').on('submit', function(event) {
                event.preventDefault();
                $('#loadingSpinner').show();
                $('.is-invalid').removeClass('is-invalid');
                $('.error-message').remove();

                if (!validateFields(true)) { // Scroll to first error field if validation fails
                    $('#loadingSpinner').hide();
                    return;
                }

                var formData = $(this).serialize();
                console.log(formData);
                
                $.ajax({
                    url: '{{ route('transactions.store') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Data submitted successfully!');
                        $('#loadingSpinner').hide();
                        $('#transactionForm')[0].reset();
                    },
                    error: function(xhr) {
                        $('#loadingSpinner').hide();
                        var errors = xhr.responseJSON.errors;

                        if (errors) {
                            for (const key in errors) {
                                let inputField = $('[name="' + key + '"]');
                                inputField.addClass('is-invalid');
                                inputField.after('<div class="error-message text-danger">' +
                                    errors[key][0] + '</div>');
                            }

                            // Scroll to first invalid field after backend error validation
                            $('html, body').animate({
                                scrollTop: $('.is-invalid:first').offset().top - 80
                            }, 500);

                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            // Handle SQL error (like "Out of range value for column 'deposit_accounts'")
                            let errorMessage = xhr.responseJSON.message;
                            let matchedField = null;

                            if (errorMessage.includes("Out of range value")) {
                                matchedField = $(
                                    ".amount"); // Adjust this if another field is the issue
                            }

                            if (matchedField) {
                                matchedField.addClass('is-invalid');
                                matchedField.after('<div class="error-message text-danger">' +
                                    errorMessage + '</div>');
                                $('html, body').animate({
                                    scrollTop: matchedField.offset().top - 80
                                }, 500);
                            } else {
                                alert(errorMessage); // Fallback for unknown errors
                            }

                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    }
                });
            });

        });
    </script> --}}

    <script>
        $(document).ready(function () {
            // Show/Hide issue details field based on dropdown selection
            $('#device_issues').on('change', function () {
                $('#issue_details_wrapper').toggle(this.value === 'Yes');
            });
    
            function validateFields(scrollToError = false) {
                let isValid = true;
                $('.is-invalid').removeClass('is-invalid');
                $('.error-message').remove();
                let firstInvalidField = null;
    
                // Validate Count Fields
                $(".count").each(function () {
                    let value = $(this).val();
                    if (!/^\d+$/.test(value) || parseInt(value) <= 0) {
                        showError($(this), "Please enter a valid count (positive integer).");
                        isValid = false;
                        if (!firstInvalidField) firstInvalidField = $(this);
                    }
                });
    
                // Validate Amount Fields
                $(".amount").each(function () {
                    let value = $(this).val();
                    if (!/^\d+(\.\d{1,2})?$/.test(value) || parseFloat(value) <= 0) {
                        showError($(this), "Please enter a valid amount (positive number with up to 2 decimal places).");
                        isValid = false;
                        if (!firstInvalidField) firstInvalidField = $(this);
                    }
                });
    
                // Scroll to first invalid field if needed
                if (scrollToError && firstInvalidField) {
                    $('html, body').animate({
                        scrollTop: firstInvalidField.offset().top - 80
                    }, 500);
                }
    
                return isValid;
            }
    
            function showError(element, message) {
                if (!element.next(".error-message").length) {
                    element.addClass("is-invalid").after('<div class="error-message text-danger">' + message + '</div>');
                }
            }
    
            // Restrict input for count fields (only numbers)
            $(document).on("keypress", ".count", function (e) {
                if (e.which < 48 || e.which > 57) e.preventDefault();
            });
    
            // Restrict input for amount fields (only numbers & one decimal)
            $(document).on("keypress", ".amount", function (e) {
                let keyCode = e.which;
                let currentValue = $(this).val();
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) e.preventDefault();
                if (keyCode === 46 && currentValue.includes(".")) e.preventDefault();
            });
    
            // Prevent invalid pasting
            $(document).on("paste", ".count, .amount", function (e) {
                let pastedData = e.originalEvent.clipboardData.getData("text");
                if ($(this).hasClass("count") && !/^\d+$/.test(pastedData)) e.preventDefault();
                if ($(this).hasClass("amount") && !/^\d+(\.\d{1,2})?$/.test(pastedData)) e.preventDefault();
            });
    
            // Validate on input change
            $(document).on("input", ".count, .amount", function () {
                validateFields(false);
            });
    
            // Form Submission with Spinner Inside Button
            $('#transactionForm').on('submit', function (event) {
                event.preventDefault();
                let submitButton = $('#submitButton');
                let buttonText = $('#buttonText');
                let spinner = $('#loadingSpinner');
    
                // Show spinner and disable button
                buttonText.hide();
                spinner.show();
                submitButton.prop("disabled", true);
    
                if (!validateFields(true)) {
                    // Hide spinner and enable button if validation fails
                    buttonText.show();
                    spinner.hide();
                    submitButton.prop("disabled", false);
                    return;
                }
    
                var formData = $(this).serialize();
    
                $.ajax({
                    url: '{{ route('transactions.store') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert('Data submitted successfully!');
                        $('#transactionForm')[0].reset();
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (const key in errors) {
                                showError($('[name="' + key + '"]'), errors[key][0]);
                            }
                            $('html, body').animate({
                                scrollTop: $('.is-invalid:first').offset().top - 80
                            }, 500);
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    },
                    complete: function () {
                        // Hide spinner and enable button after request completes
                        buttonText.show();
                        spinner.hide();
                        submitButton.prop("disabled", false);
                    }
                });
            });
    
        });
    </script>
    
</x-app-layout>
