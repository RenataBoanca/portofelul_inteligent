let credits = [];

function addCredit() {
  const creditContainer = document.getElementById('credit-container');
  const creditIndex = creditContainer.children.length + 1;

  const creditRow = document.createElement('div');
  creditRow.className = 'credit-row';
  creditRow.innerHTML = `
        <label for="credit${creditIndex}-value">Valoare Credit ${creditIndex}: </label>
        <input type="number" id="credit${creditIndex}-value" placeholder="Sumă totală credit ${creditIndex}" required>
        <label for="credit${creditIndex}-rate">Dobândă Credit ${creditIndex} (%): </label>
        <input type="number" id="credit${creditIndex}-rate" placeholder="Dobândă credit ${creditIndex}" required>
        <select id="credit${creditIndex}-type">
            <option value="fixed">Dobândă fixă</option>
            <option value="variable">Dobândă variabilă</option>
        </select>
    `;
  creditContainer.appendChild(creditRow);
}

function getCreditData() {
  credits = [];
  const creditContainer = document.getElementById('credit-container');
  const creditRows = creditContainer.querySelectorAll('.credit-row');

  creditRows.forEach((row, index) => {
    const value = parseFloat(
      row.querySelector(`#credit${index + 1}-value`).value
    );
    const rate = parseFloat(
      row.querySelector(`#credit${index + 1}-rate`).value
    );
    const type = row.querySelector(`#credit${index + 1}-type`).value;

    if (isNaN(value) || isNaN(rate)) {
      alert('Toate câmpurile trebuie completate corect!');
      return;
    }

    credits.push({ value, rate, type });
  });
}

function calculate() {
  getCreditData();

  const payment = parseFloat(document.getElementById('payment').value);
  if (isNaN(payment) || payment <= 0) {
    alert('Te rugăm să introduci o sumă validă pentru rambursare!');
    return;
  }

  const method = document.getElementById('method').value;

  let resultMessage = 'Rezultatele pentru rambursarea anticipată:\n';
  let totalInterestWithoutPayment = 0;
  let totalInterestWithPayment = 0;

  // Calculăm rambursarea pentru fiecare metodă
  if (method === 'snowball') {
    credits.sort((a, b) => a.value - b.value); // Rambursare după metoda bulgărelui de zăpadă
  } else if (method === 'avalanche') {
    credits.sort((a, b) => b.rate - a.rate); // Rambursare după metoda avalanșei
  }

  let totalSavings = 0;
  let totalMonthsBefore = 0;
  let totalMonthsAfter = 0;

  credits.forEach((credit, index) => {
    const timeWithoutPayment = calculateTimeToPayOff(
      credit.value,
      credit.rate,
      200
    );
    totalInterestWithoutPayment +=
      calculateInterest(credit.value, credit.rate) * timeWithoutPayment;

    const currentCreditPayment = Math.min(payment, credit.value);
    credit.value -= currentCreditPayment;
    const timeWithPayment = calculateTimeToPayOff(
      credit.value,
      credit.rate,
      200
    );
    totalInterestWithPayment +=
      calculateInterest(credit.value, credit.rate) * timeWithPayment;

    const savings = totalInterestWithoutPayment - totalInterestWithPayment;

    totalSavings = savings;

    resultMessage += `Credit ${
      index + 1
    }:\n  Suma Rambursată: ${currentCreditPayment} lei\n  Rată Dobândă: ${
      credit.rate
    }%\n  Rămas de plată: ${
      credit.value
    } lei\n  Timp estimat pentru rambursare înainte: ${timeWithoutPayment} luni\n  Timp estimat pentru rambursare după rambursare anticipată: ${timeWithPayment} luni\n\n`;
  });

  resultMessage += `Economii totale prin rambursare anticipată: ${totalSavings.toFixed(
    2
  )} lei.`;

  document.getElementById('result').textContent = resultMessage;
}

// Calculăm dobânda totală pe perioada creditului
function calculateInterest(principal, rate) {
  return (principal * rate) / 100;
}

// Calculăm timpul necesar rambursării
function calculateTimeToPayOff(principal, rate, monthlyPayment) {
  const monthlyRate = rate / 12 / 100;
  const time =
    Math.log(monthlyPayment / (monthlyPayment - principal * monthlyRate)) /
    Math.log(1 + monthlyRate);
  return Math.ceil(time);
}
