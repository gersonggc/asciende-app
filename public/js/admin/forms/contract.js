const prepareAmmount = (input) => {

    if (isFinite(input)) return input;
    const cleanMask = input.replace(/[$%]/g, "");

    if (cleanMask.includes(",")) {
        const claenPoints = cleanMask.replace(/\./g, "");

        return claenPoints.replace(",", ".")
    }

    return cleanMask;
}

if(crud.field){
    crud.field('payment_frequency').onChange(function(field) {
        let paymentDay = document.querySelector(".payment_day_of_week");
        if(field.value == 'WEEKLY')
        {
            paymentDay.style.display = 'block';

        }else{
            paymentDay.style.display = 'none';
        }

    }).change();

    crud.field('percentage').onChange(function(field) {
        let initialAmountElement = document.querySelector('[bp-field-name="initial_amount"]');
        let profitElement = document.querySelector('[bp-field-name="profit"]');
        if(!field.value)
        {
            initialAmountElement.innerHTML = '<p></p>';
            profitElement.innerHTML = '<p></p>';
        }else{

            
            const totalAmountInput = document.querySelector('input[name="total_amount"]');

            const percentage = field.value;

            const totalAmount = prepareAmmount(totalAmountInput.value);

            const percentageValue = prepareAmmount(percentage);

            const initialAmount = (totalAmount / (1 + percentageValue / 100)).toFixed(2).toString();
            
            const profit = (totalAmount - initialAmount).toFixed(2).toString();

            initialAmountElement.innerHTML = '<span class="text-info"><b>Monto Inicial: ' + initialAmount + ' $</b></span>';
            profitElement.innerHTML = '<span class="text-success"><b>Ganancia: ' + profit + ' $</b></span>';
            
            // const exchangeRateValue = new Decimal(exchangeRateInput.value);

            // const cleanMask = field.value.replace(/\$/g, "");

            // const inputValue = new Decimal(cleanMask.replace(/\./g, "").replace(",", "."));

            // const roundedValue = inputValue.mul(exchangeRateValue).toFixed(2).toString();
            
            // initialAmountElement.innerHTML = '<span class="text-success"><b>Total en BS: ' + roundedValue + '</b></span>';

        }

      }).change();

}


