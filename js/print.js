function selectTemplate(_template) {
  document.getElementsByClassName("templates")[0].style.display = "none";
  document.getElementsByClassName("container")[0].style.display = "grid";

  let templateName = _template.charAt(0).toUpperCase() + _template.slice(1);

  let title = document.getElementsByTagName("title")[0];
  title.innerHTML = title.innerHTML.replace("Invoice", templateName);

  document.getElementsByTagName("h1")[0].innerText = templateName;

  if (_template != "receipt") {
    Array.from(
      document.getElementsByClassName("only-receipt")
    ).forEach(_elt => _elt.style.display = "none");
  }

  if (_template == "estimate") {
    Array.from(
      document.getElementsByClassName("not-estimate")
    ).forEach(_elt => _elt.style.display = "none");
  }

  if (_template != "estimate") {
    Array.from(
      document.getElementsByClassName("only-estimate")
    ).forEach(_elt => _elt.style.display = "none");
  }
}