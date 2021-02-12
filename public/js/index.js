var possibleMovementsFromDragging;
function allowDrop(ev) {
    ev.preventDefault();
    /*const destinySpaceId = ev.srcElement.id;
     if (possibleMovementsFromDragging.includes(destinySpaceId))
     ev.preventDefault();*/
}

function drag(ev) {
    possibleMovementsFromDragging = JSON.parse(ev.target.getAttribute('data-canmoveto'))
    possibleMovementsFromDragging = possibleMovementsFromDragging.map(movement => {
        return `space${movement.row}${movement.column}`;
    });

    ev.dataTransfer.setData("id", ev.target.id);
    ev.dataTransfer.setData("position", ev.target.getAttribute('data-position'));
}

function drop(ev) {
    ev.preventDefault();
    var id = ev.dataTransfer.getData('id');
    var curPosition = ev.dataTransfer.getData("position");
    var position = ev.target.getAttribute('data-position');

    if (curPosition == position) {
        return;
    }
    var match = (new URLSearchParams(document.location.search)).get('match');
    var disableMovementDiv = document.getElementById('disable-movement');
    disableMovementDiv.style.display = 'flex';
    //ev.target.appendChild(document.getElementById(id));
    //window.location.href = `/application/index/move?currow=${curRow}&curcolumn=${curColumn}&row=${row}&column=${column}`;
    fetch(`/checkers/application/index/move?match=${match}&curposition=${curPosition}&position=${position}`, {
        method: 'POST'
    })
            .then(res => {
                disableMovementDiv.style.display = 'none';
                if (!res.ok) {
                    throw new Error("invalid move");
                }

                return res.text();
            })
            .then(html => {
                document.getElementById('board-container').innerHTML = html;

                setTimeout(() => {
                    fetch(`/checkers/application/index/aimove?match=${match}`)
                            .then(res => {
                                if (!res.ok) {
                                    disableMovementDiv.style.display = 'none';
                                    throw new Error('ai could not move');
                                }
                                return res.text();
                            })
                            .then(html => {
                                document.getElementById('board-container').innerHTML = html;
                                disableMovementDiv.style.display = 'none';
                            });
                }, 1000);
            })
            .catch(err => console.log(err.message));
}