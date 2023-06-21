let modalStatus = 0

let secondModalStatus = 0

let accidentCount = 0


/* Скрытие модальных окон со сменой их статусов */

const adminAccidentModal = document.getElementById('adminAccidentModal')

adminAccidentModal.addEventListener('hide.bs.modal', function (event) {
    modalStatus = 0
});



const vgsvAccidentModal = document.getElementById('vgsvAccidentModal')

vgsvAccidentModal.addEventListener('hide.bs.modal', function (event) {
    modalStatus = 0
    secondModalStatus = 1
});


vgsvAccidentModal.addEventListener('show.bs.modal', function (event) {
    modalStatus = 2
});




const vgsvSuccessAlertModal = document.getElementById('vgsvSuccessAlertModal')

vgsvSuccessAlertModal.addEventListener('hide.bs.modal', function (event) {
    modalStatus = 0
});

vgsvSuccessAlertModal.addEventListener('show.bs.modal', function (event) {
    modalStatus = 3
    secondModalStatus = 2
});
/* работа с скрытием модальных окон завершена */



function accidentRequest() {
    const request = new XMLHttpRequest();
    request.open("GET", "/CALL_VGSO/getAccidentInfo");
    request.send();
    request.addEventListener('load', function() {
        if (request.status == 200) {
            let data = JSON.parse(request.response);
            
            accidentModals(data)

        } else {
            console.error("Что-то пошло нетак");
        }

    });
}


window.addEventListener('DOMContentLoaded', () => {
    accidentRequest()
    
    setInterval(accidentRequest, 30000);
})

function accidentModals(data) {
    if(data.currentAccidents.some(() => true)) {
        if(data.userStatus == 'admin') {
            let accidentCountFirst = 0

            data.currentAccidents.forEach(accident => {
            if(accident.admin_checked != true) {
                accidentCountFirst += 1
            }
            })

            if (accidentCountFirst != accidentCount && accidentCountFirst >= 1) {
                if(modalStatus == 0) {
                    accidentAlert()
                    modalStatus = 1
                    accidentCount = accidentCountFirst
                }
            }
        } else if (data.userStatus == 'vgsv') {
            data.currentAccidents.forEach(currentAccident => {
                if(currentAccident.status == 1) {

                    dispositionMembers = Object.values(data.dispositions[currentAccident.id])

                    dispositionMembers.forEach(dispositionMember => {
                        if(data.currentUserId == dispositionMember.vgsv) {
                            
                            if(dispositionMember.current_change !== null) {
                                if((modalStatus == 0 && secondModalStatus != 1) || modalStatus == 3 && secondModalStatus == 2) {
                                    $('#vgsvSuccessAlertModal').modal('hide')
                                
                                    accidentAlert(dispositionMember.alert)
                                }
                            }
                        }
                    })
                }
            })
        }
    } else {
        if(data.userStatus == 'vgsv') {
            if(modalStatus == 0 || modalStatus == 2) {
                if(data.currentUser.success_alert) {
                    if(modalStatus == 2) {
                        $('#vgsvAccidentModal').modal('hide')
                    }
                    accidentAlert(0, 1)
                }
            }
        }
    }

}


function accidentAlert(alert = 0, success_alert = 0) {
    const modalBlock = document.getElementById('modal-block');
    modalBlock.innerHTML = '';

    if(alert != 0) {
        if (alert == 1) {
            $('#vgsvAccidentModal').modal('show')
        }
    } else if (success_alert == 1) {
        $('#vgsvSuccessAlertModal').modal('show')
    } else {
        $('#adminAccidentModal').modal('show')
    }
}


function updateTime() {
    var currentDate = new Date();
    var hours = currentDate.getHours();
    var minutes = currentDate.getMinutes();
    var seconds = currentDate.getSeconds();

    var timeString = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
    var dateString = currentDate.toLocaleDateString('ru-RU', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

    document.getElementById('current-time').textContent = timeString;
    document.getElementById('current-date').textContent = dateString;
    }

    setInterval(updateTime, 1000); // Обновлять время каждую секунду