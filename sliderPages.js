document.addEventListener('DOMContentLoaded', () => {
    const steps = document.querySelectorAll('.step');
    const nextBtns = document.querySelectorAll('.next-btn');
    const prevBtns = document.querySelectorAll('.prev-btn');
    let currentStep = 0;
    let formData = {};
    const urlApi = "http://localhost/AM/Glori/composants/formulaire/";

    steps[currentStep].classList.add('active');

    // Fonction pour mettre à jour formData
    function updateFormData() {
        const inputs = steps[currentStep].querySelectorAll('input');
        inputs.forEach(input => {
            if (input.type === 'radio' && input.checked) {
                formData[input.name] = input.value;
            } else if (input.type === 'checkbox') {
                if (input.checked) {
                    if (!formData[input.name]) {
                        formData[input.name] = [];
                    }
                    formData[input.name].push(input.value);
                }
            } else if (input.type === 'text') {
                formData[input.name] = input.value;
            }
        });
    }

    // Fonction pour annuler la dernière modification de formData
    function undoLastUpdate() {
        const keys = Object.keys(formData);
        if (keys.length > 0) {
            const lastKey = keys[keys.length - 1];
            delete formData[lastKey];
            console.log("Suppression", lastKey);
            console.log("FormData", formData);
        }
    }

    // Fonction pour appeler l'API et charger les bases de données
    function loadExistingDatabases() {
        fetch(urlApi + '/Api/loadBdd.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const zheDiv = document.getElementById('stepD');
            zheDiv.innerHTML = ''; 
            const pe = zheDiv.parentElement;
            const h2 = pe.querySelector('h2');
            h2.innerText = 'Choisissez la base de données que vous voulez utiliser !';

            data.databases.forEach(db => {
                const label = document.createElement('label');
                const radio = document.createElement('input');
                const div = document.createElement('div');
                const span = document.createElement('span');

                div.classList.add("radio-button");
                radio.type = 'radio';
                radio.name = 'bdds';
                radio.value = db.Database;
                radio.classList.add("radio");
                span.innerText = db.Database;

                zheDiv.appendChild(label);
                label.appendChild(radio);
                label.appendChild(div);
                div.appendChild(span);
            });
        })
        .catch(error => {
            console.error('Erreur lors de la requête fetch:', error);
        });
    }

    // Fonction pour appeler l'API et charger les tables
    function loadTables() {
        fetch(urlApi + '/Api/loadTables.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
        .then(response => response.json())
        .then(data => {
            const zheDiv = document.getElementById('stepT');
            zheDiv.innerHTML = ''; 
            const pe = zheDiv.parentElement;
            const h2 = pe.querySelector('h2');
            h2.innerText = 'Choisissez les tables (max 3) que vous voulez utiliser !';

            data.tables.forEach(table => {
                const label = document.createElement('label');
                const checkbox = document.createElement('input');
                const div = document.createElement('div');
                const span = document.createElement('span');

                div.classList.add("radio-button");
                checkbox.type = 'checkbox';
                checkbox.name = 'tables';
                checkbox.value = table;
                checkbox.classList.add("checkbox");
                span.innerText = table;

                zheDiv.appendChild(label);
                label.appendChild(checkbox);
                label.appendChild(div);
                div.appendChild(span);
            });
        });
    }

    // Fonction pour appeler l'API et charger les champs des tables sélectionnées
    function loadFields() {
        fetch(urlApi + '/Api/loadFields.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
        .then(response => response.json())
        .then(data => {
            const zheDiv = document.getElementById('stepC');
            zheDiv.innerHTML = ''; 
            const pe = zheDiv.parentElement;
            const h2 = pe.querySelector('h2');
            h2.innerText = 'Choisissez les champs à générer !';

            for (const table in data.tables) {
                const tableDiv = document.createElement('div');
                tableDiv.classList.add("radio-container", "control");
                const tableData = data.tables[table];

                const tableTitle = document.createElement('h3');
                tableTitle.innerText = table;
                zheDiv.appendChild(tableTitle);

                for (const champ in tableData) {
                    const fieldData = tableData[champ];
                    if (fieldData.Field !== 'id'){
                        const label = document.createElement('label');
                        const checkbox = document.createElement('input');
                        const div = document.createElement('div');
                        const span = document.createElement('span');

                        div.classList.add("radio-button");
                        checkbox.type = 'checkbox';
                        checkbox.classList.add("checkbox");
                        checkbox.name = "GT" + table;
                        checkbox.value = fieldData.Field + "|" + fieldData.Type;
                        span.innerText = fieldData.Field;

                        tableDiv.appendChild(label);
                        label.appendChild(checkbox);
                        label.appendChild(div);
                        div.appendChild(span);
                        zheDiv.appendChild(tableDiv);
                    }
                }
            }
        });
    }

    function recap() {
        const zheDiv = document.getElementById('stepR');
        zheDiv.innerHTML = '';

        const table = document.createElement('table');
        const thead = table.createTHead();
        const tbody = table.createTBody();

        const headerRow = thead.insertRow();
        const headerCells = ['BDD', 'Old/New', 'Tables', 'Fields'];
        headerCells.forEach(cellText => {
            const headerCell = headerRow.insertCell();
            headerCell.innerText = cellText;
        });

        const bddRow = tbody.insertRow();
        bddRow.insertCell().innerText = formData.bdds || 'N/A';
        bddRow.insertCell().innerText = formData.oldOrNew || 'N/A';
        bddRow.insertCell().innerText = (formData.tables || []).join(', ');

        const fieldsCell = bddRow.insertCell();
        const fieldsList = [];

        for (const table in formData) {
            if (table.startsWith('GT')) {
                const fieldT = formData[table];
                const zJoin = [];
                for (const field of fieldT){
                    const tableName = field.split('|')[0];
                    zJoin.push(tableName);
                }
                fieldsList.push(`${table}: ${zJoin.join(', ')}`);
            }
        }

        fieldsCell.innerText = fieldsList.join('\n');
        zheDiv.appendChild(table);
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            updateFormData();
            if (currentStep === 0 && formData.oldOrNew === 'old') {
                loadExistingDatabases();
            }
            if (currentStep === 1 && formData.oldOrNew === 'old') {
                loadTables();
            }
            if (currentStep === 2 && formData.oldOrNew === 'old') {
                loadFields();
            }
            if (currentStep === 3 && formData.oldOrNew === 'old') {
                recap();
            }

            steps[currentStep].classList.remove('active');
            currentStep++;
            if (currentStep >= steps.length) {
                currentStep = steps.length - 1;
            }
            steps[currentStep].classList.add('active');
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            steps[currentStep].classList.remove('active');
            steps[currentStep].querySelector('h2').innerText = '';
            const controls = steps[currentStep].getElementsByClassName('control');
            for (let i = 0; i < controls.length; i++) {
                while (controls[i].firstChild) {
                    controls[i].removeChild(controls[i].firstChild);
                }
            }
            currentStep--;
            if (currentStep < 0) {
                currentStep = 0;
            }
            steps[currentStep].classList.add('active');
            undoLastUpdate();
        });
    });

    document.getElementById('multiStepForm').addEventListener('submit', (e) => {
        e.preventDefault();
        updateFormData();
        fetch(urlApi + `/Api/zheBigGenerator.php?operation=${operation}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Erreur lors de la requête fetch:', error);
        });
    });
});
