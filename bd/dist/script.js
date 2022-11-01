Quill.register({
  'modules/tableUI': quillTableUI.default
}, true)

var snow = new Quill('#snow-container', {
  theme: 'snow',
  modules: {
    table: true,
    tableUI: true
  }
});

const table = snow.getModule('table');
snow.on('text-change', function(delta, old, source) {
  if (source === 'user') {
    bubble.updateContents(delta, 'api');
    updateOutput();
  }
});

function updateOutput() {
  const snowContent = snow.getContents();
  // TODO compare outputContent
}

document.querySelector('#insert-table').addEventListener('click', function() {
  table.insertTable(3, 3);
});