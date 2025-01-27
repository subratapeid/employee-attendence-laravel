<x-app-layout>
    <div class="pagetitle">
        <h1>Daily Transaction Entry</h1>
    </div>
    <section class="section daily-activity">
        <div class="mb-5 pb-4">
            <form id="transactionForm">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Transaction Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Total Deposits:</label>
                                <input type="number" class="form-control" name="deposit_count"
                                    placeholder="Enter count">
                                <input type="text" class="form-control mt-2" name="deposit_amount"
                                    placeholder="Enter amount">
                            </div>
                            <div class="col-md-6">
                                <label>Total Withdrawals:</label>
                                <input type="number" class="form-control" name="withdrawal_count"
                                    placeholder="Enter count">
                                <input type="text" class="form-control mt-2" name="withdrawal_amount"
                                    placeholder="Enter amount">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Fund Transfers:</label>
                                <input type="number" class="form-control" name="transfer_count"
                                    placeholder="Enter count">
                                <input type="text" class="form-control mt-2" name="transfer_amount"
                                    placeholder="Enter amount">
                            </div>
                            <div class="col-md-6">
                                <label>Other Transactions:</label>
                                <input type="number" class="form-control mb-2" name="other_count"
                                    placeholder="Enter count">
                                <input type="text" class="form-control mt-2" name="other_details"
                                    placeholder="Enter details">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Enrollment Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>New Customer Enrollments:</label>
                                <input type="number" class="form-control" name="enrollment_count"
                                    placeholder="Enter count">
                            </div>
                            <div class="col-md-6">
                                <label>Savings Accounts:</label>
                                <input type="number" class="form-control" name="savings_count"
                                    placeholder="Enter count">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Recurring/Fixed Deposit Accounts:</label>
                                <input type="number" class="form-control" name="deposit_accounts"
                                    placeholder="Enter count">
                            </div>
                            <div class="col-md-6">
                                <label>Aadhaar Seeding:</label>
                                <input type="number" class="form-control" name="aadhaar_seeding"
                                    placeholder="Enter count">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>e-KYC Processed:</label>
                            <input type="number" class="form-control" name="ekyc_processed" placeholder="Enter count">
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Device/Technical Issues</h5>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label for="device_issues">POS/Device Issues:</label>
                                <select class="form-control" name="device_issues" id="device_issues">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="issue_details_wrapper" style="display: none;">
                                <label for="issue_details">Issue Details:</label>
                                <textarea class="form-control" name="issue_details" id="issue_details" placeholder="Enter details" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-center pb-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <div id="loadingSpinner" style="display:none;">Processing...</div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#device_issues').on('change', function() {
                if (this.value === 'Yes') {
                    $('#issue_details_wrapper').css('display', 'block');
                } else {
                    $('#issue_details_wrapper').css('display', 'none');
                }
            });

            $('#transactionForm').on('submit', function(event) {
                event.preventDefault();
                $('#loadingSpinner').show();
                $('.is-invalid').removeClass('is-invalid');
                $('.error-message').remove();

                $.ajax({
                    url: '{{ route('transactions.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
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
                            $('html, body').animate({
                                scrollTop: $('.is-invalid:first').offset().top - 80
                            }, 500);
                        } else {
                            alert('An unexpected error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
