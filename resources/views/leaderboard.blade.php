<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="{{ asset('css/leaderboard.css') }}">
</head>
<body>
    <div>
        <table id="leaderboard">
            <thead>
                <tr>
                    <th>Delete Action</th>
                    <th>Participant</th>
                    <th>Add</th>
                    <th>Subtract</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody id="participant-list">
            </tbody>
        </table>

        <div id='buttons'>
            <button id="add-participant">Add Participant</button>
            <button id="show-winner">Show Winner</button>
        </div>
        <div id="participant-details"></div>
        <form id="add-participant-form"></form>
        <div id="add-participant-alert"></div>
        <div id="winner-details"></div>
    </div>
    <script src="{{ asset('js/leaderboard.js') }}"></script>
</body>
</html>
