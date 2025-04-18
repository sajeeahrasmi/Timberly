
function showForm(category) {
    const timberCard = document.getElementById('timber-card');
    const lumberCard = document.getElementById('lumber-card');
    const timberForm = document.getElementById('timber-form');
    const lumberForm = document.getElementById('lumber-form');

    if (category === 'timber') {
        timberCard.classList.add('active');
        lumberCard.classList.remove('active');
        timberForm.classList.add('active');
        lumberForm.classList.remove('active');
    } else if (category === 'lumber') {
        lumberCard.classList.add('active');
        timberCard.classList.remove('active');
        lumberForm.classList.add('active');
        timberForm.classList.remove('active');
    }
}