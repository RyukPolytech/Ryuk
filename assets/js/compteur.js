const compteur = document.getElementById("compteur");
setInterval(() => {
    let dontStop = true;
    let i = 0;
    while(dontStop) {
        let incrementedCompteur = compteur.children.namedItem("compteur-num" + i);
        if (incrementedCompteur.innerHTML == 9) {
            if (i === 1) {
                const audio = document.getElementById("death");
                audio.playbackRate=0.5;
	            audio.play();
            }
            incrementedCompteur.innerHTML = 0;
            i++;
        }
        else {
            incrementedCompteur.innerHTML = Number(incrementedCompteur.innerHTML) + 1;
            dontStop = false;
        }
        if (i >=  11) {
            dontStop = false;
        }
    }
}, 555)