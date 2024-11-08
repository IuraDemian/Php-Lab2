document.addEventListener("DOMContentLoaded", () => 
{
    const queryParams = getQueryParams();

    if (queryParams.country || queryParams.minAge) 
    {
        document.getElementById("filterCountry").value = queryParams.country;
        document.getElementById("filterAge").value = queryParams.minAge;
        filterParticipants();
    } 
    else 
    {
        loadParticipants();
    }
});

function getQueryParams() 
{
    const params = new URLSearchParams(window.location.search);
    return  {
        country: params.get('country') || '',
        minAge: params.get('min_age') || ''
    };
}

let participants = [];


function loadParticipants() 
{
    const country = document.getElementById("filterCountry").value;
    const age = document.getElementById("filterAge").value;
    
    fetch("data.php", 
    {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=getAll"
    })
    .then(response => response.json())
    .then(data => 
    {
        participants = data;
        updateTable(data);
    });
}

function filterParticipants() 
{
    const country = document.getElementById("filterCountry").value;
    const age = document.getElementById("filterAge").value;

    fetch("data.php", 
    {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=filter&country=${country}&age=${age}`
    })
    .then(response => response.json())
    .then(data => 
    {
            participants = data; 
            updateTable(data);
    });
}

function addParticipant() 
{
    const name = document.getElementById("newName").value;
    const gender = document.getElementById("newGender").value;
    const age = document.getElementById("newAge").value;
    const country = document.getElementById("newCountry").value;
    const score1 = document.getElementById("newScore1").value;
    const score2 = document.getElementById("newScore2").value;
    const score3 = document.getElementById("newScore3").value;

    if (!name) 
    {
        alert("ПІБ не може бути порожнім.");
        return;
    }
    if (gender !== "чоловік" && gender !== "жінка") 
    {
        alert("Стать повинна бути або 'чоловік' або 'жінка'.");
        return;
    }
    if (isNaN(age) || age < 0 || age > 120) 
    {
        alert("Вік повинен бути від 0 до 120 років.");
        return;
    }

    fetch("data.php", 
    {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=add&name=${name}&gender=${gender}&age=${age}&country=${country}&score1=${score1}&score2=${score2}&score3=${score3}`
    })
    .then(response => response.json())
    .then(data => 
    {
        toggleAddForm();
        loadParticipants();
    });
}

function editParticipant(code) 
{
    const participant = participants.find(p => p.code === code);
    if (participant) 
    {
        document.getElementById("editCode").value = participant.code;
        document.getElementById("editName").value = participant.name;
        document.getElementById("editGender").value = participant.gender;
        document.getElementById("editAge").value = participant.age;
        document.getElementById("editCountry").value = participant.country;
        document.getElementById("editScore1").value = participant.score1;
        document.getElementById("editScore2").value = participant.score2;
        document.getElementById("editScore3").value = participant.score3;
        toggleEditForm();
    }
}

function saveEdit() 
{
    const code = document.getElementById("editCode").value;
    const name = document.getElementById("editName").value.trim();
    const gender = document.getElementById("editGender").value;
    const age = parseInt(document.getElementById("editAge").value, 10);
    const country = document.getElementById("editCountry").value.trim();
    const score1 = parseInt(document.getElementById("editScore1").value, 10);
    const score2 = parseInt(document.getElementById("editScore2").value, 10);
    const score3 = parseInt(document.getElementById("editScore3").value, 10);

    if (!name) 
    {
        alert("ПІБ не може бути порожнім.");
        return;
    }
    if (gender !== "чоловік" && gender !== "жінка") 
    {
        alert("Стать повинна бути або 'чоловік' або 'жінка'.");
        return;
    }
    if (isNaN(age) || age < 0 || age > 120) 
    {
        alert("Вік повинен бути від 0 до 120 років.");
        return;
    }

    fetch("data.php", 
    {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=update&code=${code}&name=${name}&gender=${gender}&age=${age}&country=${country}&score1=${score1}&score2=${score2}&score3=${score3}`
    })
    .then(response => response.json())
    .then(data => 
    {
        toggleEditForm();
        loadParticipants();
    });
}

function updateTable(data) 
{
    const tableBody = document.getElementById("tableBody");
    tableBody.innerHTML = "";
    data.forEach(participant => 
    {
        const row = document.createElement("tr");
        row.innerHTML = 
        `
            <td>${participant.code}</td>
            <td>${participant.name}</td>
            <td>${participant.gender}</td>
            <td>${participant.age}</td>
            <td>${participant.country}</td>
            <td>${participant.score1}</td>
            <td>${participant.score2}</td>
            <td>${participant.score3}</td>
            <td><button onclick="editParticipant(${participant.code})">Редагувати</button></td> 
        `;
        tableBody.appendChild(row);
    });
}

function resetParticipants() 
{
    fetch("data.php", 
    {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=reset"
    })
    .then(response => response.json())
    .then(data =>
    {
        participants = data;
        updateTable(data);
    });
}

function toggleAddForm() 
{
    const form = document.getElementById("addForm");
    form.style.display = form.style.display === "none" ? "block" : "none";
}

function toggleEditForm() 
{
    const form = document.getElementById("editForm");
    form.style.display = (form.style.display === "none" || form.style.display === "") ? "block" : "none";
}

function saveData() 
{
    fetch('data.php', 
    {
        method: 'POST',
        headers: 
        {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=save'
    })
    .then(response => response.json())
    .then(data => 
    {
        alert(data.message);
    });
}

function loadData() 
{
    fetch('data.php', 
    {
        method: 'POST',
        headers: 
        {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=load'
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') 
        {
            alert(data.message);
        } 
        else 
        {
            participants = data;
            updateTable(data);
        }
    });
}
