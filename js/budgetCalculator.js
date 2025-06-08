document.addEventListener('DOMContentLoaded', function () {
  const categories = {
    income: {
      Salarii: ['Salariu principal', 'Al doilea job'],
      Alocații: ['Copii', 'Familie'],
      Pensii: ['Stat', 'Privată'],
      'Bonuri de masă': ['Angajator'],
      Cadouri: ['Familie', 'Prieteni'],
      Bonusuri: ['Bonus lunar'],
      Chirii: ['Locuință', 'Spațiu comercial'],
      Indemnizații: ['Maternitate', 'Șomaj'],
      'Venituri pasive': [
        'Dobanzi',
        'Dividente',
        'Titluri de autor',
        'Castig din vanzarea actiunilor',
        'Altele',
      ],
      Altele: ['Freelance', 'Diverse'],
    },
    expenses: {
      Nevoi: [
        'Chirie/Credit locuintă',
        'Cumparaturi esentiale',
        'Transport',
        'Utilități',
        'Sănătate',
        'Taxa gradinita/scoala',
        'Intretinere persoanala(coafor, cosmetica etc.)',
      ],
      'Dorințe pe termen scurt': ['Haine', 'Ieșiri', 'Abonamente', 'Vicii'],
      'Dorințe pe termen lung': ['Mașină', 'Călătorii', 'Altele'],
      Donații: ['Caritate', 'Ajutor familie'],
      Investiții: ['Acțiuni', 'Obligațiuni', 'Fonduri', 'Imobiliare', 'Altele'],
      Educație: ['Cursuri', 'Cărți'],
      Economii: ['Fond urgență', 'Pensii'],
      Credite: ['Credit de nevoi personale', 'Card de credit'],
      'Cheltuieli anuale (introdu aceste sume pe an si se va imparti la 12 luni in pasul final':
        [
          'Asigurare PAD',
          'Asigurare facultativa casa',
          'Impozit casa',
          'Revizie centrala',
          'Asigurare masina',
          'Impozit masina',
          'Revizie masina',
          'RoVigneta',
          'ITP',
          'Schimb cauciucuri',
          'Altele',
        ],
    },
  };

  // Funcția pentru a crea input-uri pentru categorii
  function createCategoryInputs(sectionId, categoryData) {
    const section = document.getElementById(sectionId);
    for (const [category, subcategories] of Object.entries(categoryData)) {
      const categoryDiv = document.createElement('div');
      categoryDiv.innerHTML = `<h4>${category}</h4>`;

      subcategories.forEach((subcategory) => {
        const label = document.createElement('label');
        label.textContent = subcategory;
        const input = document.createElement('input');
        input.type = 'number';
        input.placeholder = `Suma pentru ${subcategory}`;
        input.dataset.category = sectionId;
        input.dataset.subcategory = subcategory;

        categoryDiv.appendChild(label);
        categoryDiv.appendChild(input);
        categoryDiv.appendChild(document.createElement('br'));
      });

      section.appendChild(categoryDiv);
    }
  }

  createCategoryInputs('income-section', categories.income);
  createCategoryInputs('expenses-section', categories.expenses);

  const calculateBtn = document.getElementById('calculateBtn');
  const resultDisplay = document.getElementById('result');

  calculateBtn.addEventListener('click', function () {
    let totalIncome = 0;
    let totalExpenses = 0;
    let totalCheltuieliAnuale = 0;

    // Calculăm veniturile
    document
      .querySelectorAll("[data-category='income-section']")
      .forEach((input) => {
        totalIncome += parseFloat(input.value) || 0;
      });

    // Calculăm cheltuielile
    document
      .querySelectorAll("[data-category='expenses-section']")
      .forEach((input) => {
        const value = parseFloat(input.value) || 0;
        if (
          input.dataset.subcategory in categories.expenses['Cheltuieli anuale']
        ) {
          totalCheltuieliAnuale += value;
        } else {
          totalExpenses += value;
        }
      });

    // Împărțim cheltuielile anuale la 12 și le adăugăm la total
    totalExpenses += totalCheltuieliAnuale / 12;

    // Calculăm soldul final
    const balance = totalIncome - totalExpenses;

    if (balance > 0) {
      resultDisplay.textContent = `Buget pozitiv: +${balance.toFixed(2)} RON`;
      resultDisplay.style.color = 'green';
    } else if (balance < 0) {
      resultDisplay.textContent = `Buget negativ: ${balance.toFixed(2)} RON`;
      resultDisplay.style.color = 'red';
    } else {
      resultDisplay.textContent = 'Buget echilibrat (0 RON)';
      resultDisplay.style.color = 'black';
    }
  });
});
