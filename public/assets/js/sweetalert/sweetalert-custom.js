var SweetAlert_custom = {
    init: function () {
      document.querySelector(".sweet-1").onclick = function () {
        Swal.fire(
          'Good job!',
          'You clicked the button!',
          'success'
        )
      },
      document.querySelector(".sweet-2").onclick = function () {
        Swal.fire(
          'It\'s Magic!',
          'Thank you for visiting Admiro theme'
          )
      },
      document.querySelector(".sweet-4").onclick = function () {
        Swal.fire(
          'The Internet?',
          'That thing is still around?',
          'question'
        )
      },
      (document.querySelector(".sweet-5").onclick = function () {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#2e8e87',
          cancelButtonColor: '#C42A02',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          }
        })
      }),
      document.querySelector(".sweet-6").onclick = function () {
        Swal.fire({
          title: 'Custom animation with Animate.css',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          }
        })
      },
      (document.querySelector(".sweet-7").onclick = function () {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
          footer: '<a href="https://sweetalert2.github.io/" target="_blank">Why do I have this issue?</a>'
        })
      }),
      document.querySelector(".sweet-8").onclick = function () {
        (async () => {
          const { value: email } = await Swal.fire({
            title: 'Input email address',
            input: 'email',
            inputLabel: 'Your email address',
            inputPlaceholder: 'Enter your email address'
          })
          if (email) {
            Swal.fire(`Entered email: ${email}`)
          }
          })()
      },
      document.querySelector(".sweet-11").onclick = function () {
        Swal.fire({
          title: 'Submit your Github username',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Look up',
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch(`//api.github.com/users/${login}`)
              .then(response => {
                if (!response.ok) {
                  throw new Error(response.statusText)
                }
                return response.json()
              })
              .catch(error => {
                Swal.showValidationMessage(
                  `Request failed: ${error}`
                )
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: `${result.value.login}'s avatar`,
              imageUrl: result.value.avatar_url
            })
          }
        })
      },
      document.querySelector('.sweet-12').onclick = function(){
        Swal.fire({
          title: 'Do you want to save the changes?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'Save',
          denyButtonText: `Don't save`,
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire('Saved!', '', 'success')
          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }
        })
      },
      (document.querySelector(".sweet-13").onclick = function () {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
        Toast.fire({
          icon: 'success',
          title: 'Signed in successfully'
        })
      });
      document.querySelector(".sweet-14").onclick = function () {
        Swal.fire({
          title: 'Timer Alert',
          text: "just a wait! I will close in 30 second!",
          showConfirmButton: false,
          timer: 1500
        })
      };
      document.querySelector(".sweet-15").onclick = function () {
        Swal.fire({
          title: 'هل تريد الاستمرار؟',
          icon: 'question',
          iconHtml: '؟',
          confirmButtonText: 'نعم',
          cancelButtonText: 'لا',
          showCancelButton: true,
          showCloseButton: true
        })
      };
      document.querySelector(".sweet-16").onclick = function () {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Your work has been saved',
          showConfirmButton: false,
          timer: 1500
        })
      };
      document.querySelector(".sweet-17").onclick = function () {
        Swal.fire({
          position: 'top-start',
          icon: 'error',
          title: 'Something went wrong!',
          showConfirmButton: false,
          timer: 1500
        })
      };
      document.querySelector(".sweet-18").onclick = function () {
        Swal.fire({
          position: 'bottom-start',
          icon: 'info',
          html:
              'You can use, ' +
              '<a class="font-primary f-18" href="//sweetalert2.github.io" target="_blank">Alerts</a> ' +
              'and other HTML tags',
          showConfirmButton: false,
        })
      };
      document.querySelector(".sweet-19").onclick = function () {
        Swal.fire({
          position: 'bottom-end',
          icon: 'success',
          title: 'Your work has been saved',
          showConfirmButton: false,
          timer: 1500
        })
      };
      document.querySelector(".sweet-20").onclick = function () {
        let timerInterval
        Swal.fire({
          title: 'Auto close alert!',
          html: 'I will close in <b></b> milliseconds.',
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
              b.textContent = Swal.getTimerLeft()
            }, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
          }
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
          }
        })
      };
      document.querySelector(".sweet-21").onclick = function () {
        Swal.fire({
          title: 'Sweet!',
          text: 'Modal with a custom image.',
          imageUrl: 'https://unsplash.it/400/200',
          imageWidth: 400,
          imageHeight: 200,
          imageAlt: 'Custom image',
          showClass: {
            popup: 'animate__animated animate__zoomIn'
          },
        })
      };
      document.querySelector(".sweet-22").onclick = function () {
        (async () => {
          const ipAPI = '//api.ipify.org?format=json'
          const inputValue = fetch(ipAPI)
            .then(response => response.json())
            .then(data => data.ip)
          const { value: ipAddress } = await Swal.fire({
            title: 'Enter your IP address',
            input: 'text',
            inputLabel: 'Your IP address',
            inputValue: inputValue,
            showCancelButton: true,
            inputValidator: (value) => {
              if (!value) {
                return 'You need to write something!'
              }
            }
          })
          if (ipAddress) {
            Swal.fire(`Your IP address is ${ipAddress}`)
          }
          })()
      };
      document.querySelector(".sweet-23").onclick = function () {
        (async () => {
          const { value: url } = await Swal.fire({
            input: 'url',
            inputLabel: 'URL address',
            inputPlaceholder: 'Enter the URL'
          })
          if (url) {
            Swal.fire(`Entered URL: ${url}`)
          }
          })()
      };
      document.querySelector(".sweet-24").onclick = function () {
        (async () => {
          const { value: password } = await Swal.fire({
            title: 'Enter your password',
            input: 'password',
            inputLabel: 'Password',
            inputPlaceholder: 'Enter your password',
            inputAttributes: {
              maxlength: 10,
              autocapitalize: 'off',
              autocorrect: 'off'
            }
          })
          if (password) {
            Swal.fire(`Entered password: ${password}`)
          }
          })()
      };
      document.querySelector(".sweet-25").onclick = function () {
        (async () => {
          const { value: text } = await Swal.fire({
            input: 'textarea',
            inputLabel: 'Message',
            inputPlaceholder: 'Type your message here...',
            inputAttributes: {
              'aria-label': 'Type your message here'
            },
            showCancelButton: true
          })
          if (text) {
            Swal.fire(text)
          }
          })()
      };
      document.querySelector(".sweet-26").onclick = function () {
        (async () => {
          const { value: fruit } = await Swal.fire({
            title: 'Select field validation',
            input: 'select',
            inputOptions: {
              'Fruits': {
                apples: 'Apples',
                bananas: 'Bananas',
                grapes: 'Grapes',
                oranges: 'Oranges'
              },
              'Vegetables': {
                potato: 'Potato',
                broccoli: 'Broccoli',
                carrot: 'Carrot'
              },
              'icecream': 'Ice cream'
            },
            inputPlaceholder: 'Select a fruit',
            showCancelButton: true,
            inputValidator: (value) => {
              return new Promise((resolve) => {
                if (value === 'oranges') {
                  resolve()
                } else {
                  resolve('You need to select oranges :)')
                }
              })
            }
          })
          if (fruit) {
            Swal.fire(`You selected: ${fruit}`)
          }
          })()
      };
      document.querySelector(".sweet-27").onclick = function () {
        (async () => {
          /* inputOptions can be an object or Promise */
          const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
              resolve({
                '#ff0000': 'Red',
                '#00ff00': 'Green',
                '#0000ff': 'Blue'
              })
            }, 1000)
          })
          const { value: color } = await Swal.fire({
            title: 'Select color',
            input: 'radio',
            inputOptions: inputOptions,
            inputValidator: (value) => {
              if (!value) {
                return 'You need to choose something!'
              }
            }
          })
          if (color) {
            Swal.fire({ html: `You selected: ${color}` })
          }
          })()
      };
      document.querySelector(".sweet-28").onclick = function () {
        (async () => {
          const { value: accept } = await Swal.fire({
            title: 'Terms and conditions',
            input: 'checkbox',
            inputValue: 1,
            inputPlaceholder:
              'I agree with the terms and conditions',
            confirmButtonText:
              'Continue <i class="fa fa-arrow-right"></i>',
            inputValidator: (result) => {
              return !result && 'You need to agree with T&C'
            }
          })
          if (accept) {
            Swal.fire('You agreed with T&C :)')
          }
          })()
      };
      document.querySelector(".sweet-29").onclick = function () {
        Swal.fire({
          title: 'How old are you?',
          icon: 'question',
          input: 'range',
          inputLabel: 'Your age',
          inputAttributes: {
            min: 8,
            max: 120,
            step: 1
          },
          inputValue: 25
        })
      };
    },
  };
  SweetAlert_custom.init();