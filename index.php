<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Турнір</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <h1>Турнір</h1>

    <table id="participantTable">
        <thead>
            <tr>
                <th>Код</th>
                <th>ПІБ</th>
                <th>Стать</th>
                <th>Вік</th>
                <th>Країна</th>
                <th>Оцінка 1</th>
                <th>Оцінка 2</th>
                <th>Оцінка 3</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody id="tableBody"> </tbody>
    </table>

    <div>
        <label>Країна:</label>
        <input type="text" id="filterCountry">
        <label>Вік не менше:</label>
        <input type="number" id="filterAge">
        <button onclick="filterParticipants()">Фільтрувати</button>
    </div>

    <button onclick="toggleAddForm()">Додати учасника</button>

    <div id="addForm" style="display:none;">
        <input type="text" id="newCode" placeholder="Код">
        <input type="text" id="newName" placeholder="ПІБ">
        <select id="newGender">
            <option value="">Виберіть стать</option>
            <option value="чоловік">Чоловік</option>
            <option value="жінка">Жінка</option>
        </select>
        <input type="number" id="newAge" placeholder="Вік">
        <input type="text" id="newCountry" placeholder="Країна">
        <input type="number" id="newScore1" placeholder="Оцінка 1">
        <input type="number" id="newScore2" placeholder="Оцінка 2">
        <input type="number" id="newScore3" placeholder="Оцінка 3">
        <button onclick="addParticipant()">Додати</button>
    </div>

    <div id="editForm" style="display:none;">
        <input type="hidden" id="editCode">
        <input type="text" id="editName" placeholder="ПІБ">
        <select id="editGender">
            <option value="">Виберіть стать</option>
            <option value="чоловік">Чоловік</option>
            <option value="жінка">Жінка</option>
        </select>
        <input type="number" id="editAge" placeholder="Вік">
        <input type="text" id="editCountry" placeholder="Країна">
        <input type="number" id="editScore1" placeholder="Оцінка 1">
        <input type="number" id="editScore2" placeholder="Оцінка 2">
        <input type="number" id="editScore3" placeholder="Оцінка 3">
        <button onclick="saveEdit()">Зберегти</button>
        <button onclick="toggleEditForm()">Скасувати</button>
    </div>

    <div style="position: absolute; bottom: -60px; right: 10px;">
        <button onclick="resetParticipants()">Перезапустити</button>
    </div>

    <div style="position: absolute; bottom: -60px; left: 10px;">
        <button onclick="saveData()">Зберегти дані</button>
    </div>

    <div style="position: absolute; bottom: -60px; left: 120px;">
        <button onclick="loadData()">Завантажити дані</button>
    </div>

    <script src="./js/script.js"></script>
</body>
</html>