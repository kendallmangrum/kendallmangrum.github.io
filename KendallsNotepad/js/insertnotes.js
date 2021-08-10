
function insertNotePreviews() {
    const notespot = document.querySelector('#container');

    noteList.forEach(function(note, index) {
        const noteHTML = `
        <div class='note' data-position='${index}'>
            <figure data-note-name='${note.name}' data-note-date='${note.date}'>
                <img src='images/paper.jpg'>
                <figcaption>
                    <span class='note-title'>${note.name}</span>
                    <span class='note-date'>${note.date}</span><br>
                    <span class='note-preview'>${note.preview}</span>
                </figcaption>
            </figure>
        </div>`;
        notespot.insertAdjacentHTML('beforeend', noteHTML);
    });



    document.querySelectorAll('.note').forEach(note => {
        note.addEventListener('click', () => {
            selectNote(note);
        });
    });
}


function selectNote(note) {
    let clickedNote = noteList[note.dataset.position];
    // console.log(clickedNote);
    sessionStorage.setItem('chosen', note.dataset.position);
    window.location.href = clickedNote.page + '.html';
    // loadSelectedNote();
}


function loadSelectedNote() {
    let selectedPosition = sessionStorage.getItem('chosen');
    console.log(selectedPosition);
    let chosenNote = noteList[selectedPosition];
    const noteArea = document.querySelector('#notepad-container');
    const selectedNoteHTML = `
        <div class='notepad'>
            <figure class='notepad-figure'>
            
                <figcaption>
                    <span class='title'>${chosenNote.name}</span>
                    <br>
                    <span class='date'>${chosenNote.date}</span>
                    <span class='content'>${chosenNote.content}</span>
                    <span class='catchphrase'>${chosenNote.catchphrase}</span>
                    <br>
                    <span class='signature'>${chosenNote.signature}</span>
                </figcaption>
            </figure>
        </div>
    `;
    noteArea.insertAdjacentHTML('beforeend', selectedNoteHTML);
}



