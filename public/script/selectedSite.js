function changeIdIfPageNameMatches(targetId, expectedPageName, newId) {
    window.onload = function () {
       // Get the current page title
       const currentPageName = document.title;
    
       // Check if the page title matches the expected one
       if (currentPageName === expectedPageName) {
           // Get the element by targetId
           const element = document.getElementById(targetId);
    
           // Check if the element exists
           if (element) {
           // Change the element's ID
             element.id = newId;
             console.log("Completed")
           } else {
             console.error(`Element with ID '${targetId}' not found.`);
           }
         }
       }
}