
document.onreadystatechange = () => {
    if(document.readyState === "complete") {
        jwplayer('jwplayer').setup(jwPlayerSetup);
    }
};