{{-- Define routes for js files --}}

    var getTime = "{{ route('get-time') }}";
    var getDutyStatus = "{{ route('duty-status') }}";
    var postDutyStatus = "{{ route('post-duty-status') }}";
    var resolveDuty = "{{ route('resolve-duty') }}";
    var startDutyDataSave = "{{ route('startDutyDataSave') }}";
    var checkDataEntryStatus = "{{ route('checkDataEntryStatus') }}";

    var dashboardData = "{{ route('dashboard-data') }}";
    var getTotalWorkingHours = "{{ route('getTotalWorkingHours') }}";
    var getAttendanceCount = "{{ route('getAttendanceCount') }}";
    var getTotalLeaves = "{{ route('getTotalLeaves') }}";
    var getLateArrivals = "{{ route('getLateArrivals') }}";
    var getEarlyDepartures = "{{ route('getEarlyDepartures') }}";
    var getOvertime = "{{ route('getOvertime') }}";

    var getAdminDashboardData = "{{ route('getAdminDashboardData') }}";
    var getAdminAttendanceCount = "{{ route('getAdminAttendanceCount') }}";
    var getAdminTotalLeaves = "{{ route('getAdminTotalLeaves') }}";
    var getAdminTotalAbsent = "{{ route('getAdminTotalAbsent') }}";
    var getAdminLateArrivals = "{{ route('getAdminLateArrivals') }}";
    var getAdminEarlyDepartures = "{{ route('getAdminEarlyDepartures') }}";
    var getAdminOntime = "{{ route('getAdminOntime') }}";

    var getCalendarData = "{{ route('getCalendarData') }}";
    var getDuties = "{{ route('getDuties') }}";
    var getAvailableOptions = "{{ route('getAvailableOptions') }}";

    var transactionToday = "";
    var transactions = "{{ route('transactions.index') }}";


    var baseUrl = "{{ asset('public') }}";
    