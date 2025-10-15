document.addEventListener("DOMContentLoaded", () => {
  const saveBtn = document.getElementById("saveBtn");

  saveBtn.addEventListener("click", () => {
    const rows = document.querySelectorAll("tr");
    const modules = [];

    rows.forEach((row) => {
      const toggle = row.querySelector(".toggle");
      if (!toggle) return;

      const id = toggle.dataset.id;
      const enabled = toggle.checked;
      const order = parseInt(row.querySelector(".order").value);
      const name = row.children[0].innerText;

      modules.push({ id, name, enabled, order });
    });

    fetch("/modular_project/api/module_api.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(modules)
    })
      .then(res => res.json())
      .then(() => alert("Lưu thành công!"));
  });
});
