function footerYear(){
    const date = new Date();
    const currentYear = date.getFullYear();
    return document.write(currentYear);
}

footerYear();