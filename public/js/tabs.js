// import axios from 'axios';
{/* <script src="{{ resources('js/tabs.js') }}"></script> */}

// tabs.js
// document.addEventListener('DOMContentLoaded', function () {
//   const tab1 = document.getElementById('tab3-tab');

//   tab1.addEventListener('click', function () {
//     const route = tab1.getAttribute('data-route');

//     fetch(route)
//       .then(response => response.json())
//       .then(data => {
//         // Aqui, você pode processar os dados dos clientes
//         // e atualizar a visualização da aba "Clientes"
//         console.log(data);
//       });
//   });
// });

document.addEventListener('DOMContentLoaded', function () {
  const tab1 = document.getElementById('tab3-tab');

  tab1.addEventListener('click', function () {
    const route = tab1.getAttribute('data-route');

    axios.get(route)
      .then(response => {
        const data = response.data;
        // Aqui, você pode processar os dados dos clientes
        console.log(data);
      });
  });
});



// document.addEventListener('DOMContentLoaded', function () {
//   const tab1 = document.getElementById('tab3-tab');

//   tab1.addEventListener('click', function () {
//     const route = tab1.getAttribute('data-route');

//     axios.get(route)
//       .then(response => {
//         const data = response.data;
//         // Aqui, você pode processar os dados dos clientes
//         console.log(data)
//         //
//       })
//   })
// })

// document.addEventListener('DOMContentLoaded', function () {
//   const tabs = document.querySelectorAll('.nav-link[data-route]');

//   tabs.forEach(tab => {
//       tab.addEventListener('click', function () {
//           const route = tab.getAttribute('data-route');
//           const tabContent = document.querySelector(tab.getAttribute('href'));

//           axios.get(route)
//               .then(response => {
//                   const data = response.data;
//                   // Aqui, você pode processar os dados e atualizar o conteúdo da guia (tab)
//                   console.log(data);
//               })
//               .catch(error => {
//                   console.error(error);
//               });
//       });
//   });
// });

{/* <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.nav-link[data-route]');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const route = tab.getAttribute('data-route');
                const tabContent = document.querySelector(tab.getAttribute('href'));

                axios.get(route)
                    .then(response => {
                        const data = response.data;
                        // Aqui, você pode processar os dados e atualizar o conteúdo da guia (tab)
                        console.log(data);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    });
</script> */}