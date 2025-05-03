function getCookie(nom) {
    const cookie = document.cookie.split('; ').find(function (c) {
        return c.indexOf(nom + '=') === 0;
    });
    return cookie && cookie.split('=')[1];
}

function setCookie(nom, valeur, jour) {
    let date = new Date();
    date.setTime(date.getTime() + (jour * 86400000));
    document.cookie = nom + "=" + valeur + "; expires=" + date.toUTCString() + "; path=/";
}

function changeTheme(mode) {
    const link = document.getElementById('theme');
    if (mode === 'clair') {
        link.href = 'commun_theme2.css';
    } else {
        link.href = 'commun.css';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const btntheme = document.getElementById('theme_couleur');
    const theme_sauvegarde = getCookie('theme');


    if (theme_sauvegarde === 'clair' || theme_sauvegarde === 'sombre') {
        changeTheme(theme_sauvegarde);
    } else {
        changeTheme('sombre');
        setCookie('theme', 'sombre', 30);
    }


    btntheme.addEventListener('click', function () {
        let actuelTheme;
        if (getCookie('theme') === 'clair') {
            actuelTheme = 'clair';
        } else {
            actuelTheme = 'sombre';
        }

        let nouveauTheme;
        if (actuelTheme === 'clair') {
            nouveauTheme = 'sombre';
        } else {
            nouveauTheme = 'clair';
        }

        changeTheme(nouveauTheme);
        setCookie('theme', nouveauTheme, 30);
    });
});
