
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
    // const noteInsert = document.querySelector('')
    const selectedNoteHTML = `
        <div class='notepad'>
            <figure class='notepad-figure'>
            
                <figcaption>
                    <h3><span class='title'>${chosenNote.name}</span></h3>
                    <p><span class='date'>${chosenNote.date}</span></p>
                    <p><span class='content'>${chosenNote.content}</span></p>
                    <p><span class='catchphrase'>${chosenNote.catchphrase}</span></p>
                    <p><span class='signature'>${chosenNote.signature}</span></p>
                </figcaption>
            </figure>
        </div>

        <div id="footer">
        <h3>Connect with me!</h3>
        <a href="mailto:klmangrum17@gmail.com"><i class="far fa-envelope fa-2x icon"></i></a>
				<a href="https://twitter.com/kmangrum3"><i class="fab fa-twitter fa-2x icon"></i></a>
				<a href="https://www.instagram.com/kendall_mangrum/"><i class="fab fa-instagram fa-2x icon"></i></a>
        <p>Copyright Kendall Mangrum &copy; 2021</p>
    </div>
    `;
    noteArea.insertAdjacentHTML('beforeend', selectedNoteHTML);
}



