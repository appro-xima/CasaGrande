function showSection(section) {
    // Hide all sections
    document.getElementById('tableSection').classList.add('hidden');
    document.getElementById('addSection').classList.add('hidden');
    document.getElementById('editSection').classList.add('hidden');

    // Show the selected section
    document.getElementById(section).classList.remove('hidden');
}

window.onload = function() {
    showSection('tableSection');
}

