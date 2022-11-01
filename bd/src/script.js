Quill.register({
  'modules/tableUI': quillTableUI.default
}, true)
var bubble = new Quill('#bubble-container', {
  theme: 'bubble',
  modules: {
    table: true,
  }
});
var snow = new Quill('#snow-container', {
  theme: 'snow',
  modules: {
    table: true,
    tableUI: true
  }
});
var output = new Quill('#output-container', {
  theme: 'bubble',
  modules: { table: true },
  readOnly: true,
})
bubble.on('text-change', function(delta, old, source) {
  if (source === 'user') {
    snow.updateContents(delta, 'api');
    updateOutput();
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
  const bubbleContent = bubble.getContents();
  const snowContent = snow.getContents();
  // TODO compare
  output.setContents(bubbleContent);
  const outputContent = output.getContents();
  // TODO compare outputContent
}


document.querySelector('#insert-table').addEventListener('click', function() {
  table.insertTable(3, 3);
});