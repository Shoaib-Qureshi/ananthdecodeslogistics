const dropdownBtn = document.querySelectorAll(".dropdown-btn");
const dropdown = document.querySelectorAll(".dropdown");
const hamburgerBtn = document.getElementById("hamburger");
const navMenu = document.querySelector(".menu");
const links = document.querySelectorAll(".dropdown a");

function setAriaExpandedFalse() {
    dropdownBtn.forEach((btn) => btn.setAttribute("aria-expanded", "false"));
}

function closeDropdownMenu() {
    dropdown.forEach((drop) => {
        drop.classList.remove("active");
        drop.addEventListener("click", (e) => e.stopPropagation());
    });
}

function toggleHamburger() {
    if (navMenu) {
        navMenu.classList.toggle("show");
    }
}

dropdownBtn.forEach((btn) => {
    btn.addEventListener("click", function (e) {
        const dropdownIndex = e.currentTarget.dataset.dropdown;
        const dropdownElement = document.getElementById(dropdownIndex);

        dropdownElement.classList.toggle("active");
        dropdown.forEach((drop) => {
            if (drop.id !== btn.dataset["dropdown"]) {
                drop.classList.remove("active");
            }
        });
        e.stopPropagation();
        btn.setAttribute(
            "aria-expanded",
            btn.getAttribute("aria-expanded") === "false" ? "true" : "false"
        );
    });
});

// close dropdown menu when the dropdown links are clicked
links.forEach((link) =>
    link.addEventListener("click", () => {
        closeDropdownMenu();
        setAriaExpandedFalse();
        toggleHamburger();
    })
);

// close dropdown menu when you click on the document body
document.documentElement.addEventListener("click", () => {
    closeDropdownMenu();
    setAriaExpandedFalse();
});

// close dropdown when the escape key is pressed
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        closeDropdownMenu();
        setAriaExpandedFalse();
    }
});

// toggle hamburger menu
if (hamburgerBtn) {
    hamburgerBtn.addEventListener("click", toggleHamburger);
}

window.addEventListener('scroll', function () {
    const header = document.getElementById('nav-menu');
    const menuLinks = document.querySelectorAll('.mainColor');
    const scrollPosition = window.scrollY;

    if (!header) {
        return;
    }

    if (scrollPosition >= 150) {
        header.style.backgroundColor = '#ffffff';
        header.style.boxShadow = 'rgb(0, 0, 0, .25) 0px 0px 5px 0px';
        menuLinks.forEach(link => {
            link.style.color = '#333333';
        });
    } else {
        header.style.backgroundColor = 'transparent';
        header.style.boxShadow = '0 0 0 0 #000000';
        menuLinks.forEach(link => {
            link.style.color = ''; // Reset to original color or use a specific color
        });
    }
});

// ============== Header/Menu Js End ==================
$(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll > 150) {
        $("#nav-menu").addClass("active");
    }
    else {
        $("#nav-menu").removeClass("active");
    }
});

// ========== 

// Show other input if 'Other' is selected for Job Title
const jobTitleSelect = document.getElementById('jobTitleSelect');
const jobTitleOther = document.getElementById('jobTitleOther');
if (jobTitleSelect && jobTitleOther) {
    jobTitleSelect.addEventListener('change', function () {
        jobTitleOther.style.display = this.value === 'Other' ? 'block' : 'none';
    });
}

// Show other input if 'Other' is selected for Subject
const subjectSelect = document.getElementById('subjectSelect');
const subjectOther = document.getElementById('subjectOther');
if (subjectSelect && subjectOther) {
    subjectSelect.addEventListener('change', function () {
        subjectOther.style.display = this.value === 'Other' ? 'block' : 'none';
    });
}

// =========== about tabs

const tabs = document.querySelectorAll('.tab');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const target = tab.getAttribute('data-tab');

        tabs.forEach(t => t.classList.remove('activeTab'));
        tab.classList.add('activeTab');

        contents.forEach(c => {
            c.classList.remove('activeTab');
            if (c.id === target) c.classList.add('activeTab');
        });
    });
});
