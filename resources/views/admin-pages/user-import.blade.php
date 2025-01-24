<x-app-layout>
    <div class="pagetitle">
        <h1>Import User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Import User</li>
            </ol>
        </nav>
    </div>
    <div class="mt-5 min-vh-100">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Import Bulk User Data</h4>
            </div>
            <div class="card-body">
                <form id="import-form" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload CSV/Excel File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".csv,.xlsx"
                            required>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </form>
                <div id="loading" class="mt-3 text-center d-none">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Processing file, please wait...</p>
                </div>
            </div>
        </div>

        <div id="response-message" class="mt-4"></div>

        <div id="download-section" class="mt-4 d-none">
            <div class="alert alert-danger">
                <h5>Some records failed validation. Download the error report:</h5>
                <a id="download-link" href="#" class="btn btn-warning">
                    <i class="fas fa-download"></i> Download Errors
                </a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#import-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $('#loading').removeClass('d-none'); // Show loading spinner
                $('#response-message').html('');
                $('#download-section').addClass('d-none');

                $.ajax({
                    url: "{{ route('user.import') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#loading').addClass('d-none');

                        if (response.success) {
                            $('#response-message').html(`
                                <div class="alert alert-success">
                                    <strong>Success!</strong> ${response.message}
                                </div>
                            `);
                        } else {
                            $('#response-message').html(`
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> ${response.message}
                                </div>
                            `);

                            if (response.error_file) {
                                $('#download-section').removeClass('d-none');
                                $('#download-link').attr('href', response.error_file);
                            }
                        }
                    },
                    error: function(xhr) {
                        $('#loading').addClass('d-none');

                        let errors = xhr.responseJSON.errors || {
                            file: ['Something went wrong!']
                        };
                        let errorMessage = `<div class="alert alert-danger"><ul>`;
                        $.each(errors, function(key, value) {
                            errorMessage += `<li>${value[0]}</li>`;
                        });
                        errorMessage += `</ul></div>`;

                        $('#response-message').html(errorMessage);
                    }
                });
            });
        });
    </script>
</x-app-layout>
