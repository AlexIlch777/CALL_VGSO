let previousData = null



function mainRequest() {
  axios.get('/CALL_VGSO/getMainData')
    .then(function(response) {
      let data = response.data;
      chooseAdminOrVgsv(data);
    })
    .catch(function(error) {
      console.error('Что-то пошло не так:', error);
    });
}


window.addEventListener('DOMContentLoaded', () => {
    mainRequest();

    setInterval(mainRequest, 30000);
})


function chooseAdminOrVgsv(data) {
    if(data.userStatus == 'admin') {
        adminApp(data)
    } else {
        vgsvApp(data)
    }
}


function adminApp(data) {

    const changesTable = document.querySelector('#changes-table');
    changesTable.innerHTML = '';

    const mainInfo = document.querySelector('#admin-main-info');
    mainInfo.innerHTML = '';

    let mainTable = document.createElement('table');
    mainTable.classList.add('table');

    let tableBody = document.createElement('tbody');

    mainTable.innerHTML = `
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col" style="text-align: center;"><span class="rotate">В сети</span></th>
                <th scope="col" style="text-align: center;"><span class="rotate">Оповещение</span></th>
                <th scope="col" style="text-align: center;"><span class="rotate">Выезд</span></th>
            </tr>
        </thead>
    `;

    data.vgsos.forEach(vgso => {
        let vgsoRow = document.createElement('tr');
        vgsoRow.innerHTML = `
            <th colspan="4"><span class="ms-3">${vgso.name}</span></th>
        `;
        tableBody.appendChild(vgsoRow);

        data.vgsvs.forEach(vgsv => {
            if (vgsv.vgso == vgso.id) {
                let vgsvRow = document.createElement('tr');
                vgsvRow.innerHTML = `
                    <td class="pe-5" style="font-size: 18px; word-wrap: break-word;">
                        <a href="/vgsv/${vgsv.id}">${vgsv.name}</a>
                    </td>
                    <td class="pe-3" style="text-align: center; word-break: break-all;"></td>
                    <td class="pe-3" style="text-align: center; word-break: break-all;"></td>
                    <td style="text-align: center; word-break: break-all;"></td>
                `;

                let onlineIndicator = document.createElement('div');
                onlineIndicator.classList.add('indicator');
                if (vgsv.online == 1) {
                    onlineIndicator.classList.add('green');
                } else {
                    onlineIndicator.classList.add('red');
                }
                vgsvRow.children[1].appendChild(onlineIndicator);

                let alertIndicator = document.createElement('div');
                alertIndicator.classList.add('indicator');
                if (vgsv.alert == 1) {
                    alertIndicator.classList.add('yellow');
                } else if (vgsv.alert == 2) {
                    alertIndicator.classList.add('green');
                } else {
                    alertIndicator.classList.add('red');
                }
                vgsvRow.children[2].appendChild(alertIndicator);

                let departureIndicator = document.createElement('div');
                departureIndicator.classList.add('indicator');
                if (vgsv.departure == 0) {
                    departureIndicator.classList.add('red');
                } else {
                    departureIndicator.classList.add('green');
                }
                vgsvRow.children[3].appendChild(departureIndicator);

                tableBody.appendChild(vgsvRow);
            }
        });
    });

    if(data.currentAccidents.some(() => true)) {

        data.currentAccidents.forEach(accident => {
            let accidentCard = document.createElement('div');
            accidentCard.classList.add('card');
            accidentCard.classList.add('mt-4');

            let cardHeader = document.createElement('div');
            cardHeader.classList.add('card-header');

            cardHeader.innerHTML += `
            <div style="font-size: 30px;">Информация об аварии</div>
            `

            let cardBody = document.createElement('div');
            cardBody.classList.add('card-body');

            cardBody.innerHTML += `
            <h5 class="card-title">
                Шахта, на которой произошла авария:
            </h5>
            <div class="card-text">
                ${accident.mine_name}
            </div>
            <h5 class="card-title mt-4">
                Вид аварии:
            </h5>
            <div class="card-text">
                ${accident.accident_name}
            </div>
            <h5 class="card-title mt-4">
                Дата и время аварии:
            </h5>
            <div class="card-text">
                ${accident.accident_timestamp}
            </div>
            <h5 class="card-title mt-4">
                Какой ВГСВ оповестил всех об аварии:
            </h5>
            <div class="card-text">
                ${accident.vgsv_name}
            </div>
            <h5 class="card-title mt-4">
                Кто оповестил систему об аварии:
            </h5>
            <div class="card-text">
                ${accident.sender}
            </div>
            <h5 class="card-title mt-4">
                Дата и время оповещения об аварии :
            </h5>
            <div class="card-text">
                ${accident.send_timestamp}
            </div>
            `

            let vgsvsToLiquidation = document.createElement('div')
            vgsvsToLiquidation.classList.add('card-text');

            if (accident.status == 1) {
                cardBody.innerHTML += `
                <h5 class="card-title mt-4">
                    Список ВГСВ, которые примут участие в ликвидации аварии в соответствии с Диспозицей
                </h5>`

                let vgsvsList = document.createElement('ul')

                dispositionMembers = Object.values(data.dispositions[accident.id])

                dispositionMembers.forEach(dispositionMember => {
                    let memberRow = document.createElement('li');
                    memberRow.classList.add('mt-2')

                    memberRow.innerHTML += `${dispositionMember.vgsv_name}`

                    if(dispositionMember.current_change === null) {
                        let departmentsList = document.createElement('ul')

                        memberRow.innerHTML += ` - по какой-то причине не заступил на смену (поддержание связи возможно в телефонном режиме)`

                        departmentsList.innerHTML += `Необходимые службы по диспозиции:`

                        let departments = document.createElement('ul')

                        if(dispositionMember.necessaryDepartments.duty_department == 1) {
                            departments.innerHTML += `<li>Дежурное отделение</li>`
                        }

                        if(dispositionMember.necessaryDepartments.reserve_department == 1) {
                            departments.innerHTML += `<li>Резервное отделение</li>`
                        }

                        if(dispositionMember.necessaryDepartments.mber == 1) {
                            departments.innerHTML += `<li>МБЭР</li>`
                        }

                        if(dispositionMember.necessaryDepartments.oto == 1) {
                            departments.innerHTML += `<li>ОТО</li>`
                        }

                        if(dispositionMember.necessaryDepartments.kil == 1) {
                            departments.innerHTML += `<li>КИЛ</li>`
                        }

                        if(dispositionMember.necessaryDepartments.sds == 1) {
                            departments.innerHTML += `<li>СДС</li>`
                        }

                        if(dispositionMember.necessaryDepartments.apo == 1) {
                            departments.innerHTML += `<li>АПО</li>`
                        }

                        if(dispositionMember.necessaryDepartments.asi == 1) {
                            departments.innerHTML += `<li>АСИ</li>`
                        }

                        departmentsList.appendChild(departments)

                        memberRow.appendChild(departmentsList)

                    } else {

                        memberRow.innerHTML += ` - <a href="/CALL_VGSO/vgsv/${dispositionMember.vgsv}/change/${dispositionMember.current_change}">смена, прикреплённая к данной аварии`

                        let departments = document.createElement('ul');

                        if(dispositionMember.necessaryDepartments.duty_department == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `Дежурное отделение`

                            if(dispositionMember.duty_department_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        if(dispositionMember.necessaryDepartments.reserve_department == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `Резервное отделение`

                            if(dispositionMember.reserve_department_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        if(dispositionMember.necessaryDepartments.mber == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `МБЭР`

                            if(dispositionMember.mber_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        if(dispositionMember.necessaryDepartments.oto == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `ОТО`

                            if(dispositionMember.oto_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        if(dispositionMember.necessaryDepartments.kil == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `КИЛ`

                            if(dispositionMember.kil_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        if(dispositionMember.necessaryDepartments.sds == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `СДС`

                            if(dispositionMember.sds_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        if(dispositionMember.necessaryDepartments.apo == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `АПО`

                            if(dispositionMember.apo_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        if(dispositionMember.necessaryDepartments.asi == 1) {
                            let departmentRow = document.createElement('li');

                            departmentRow.innerHTML += `АСИ`

                            if(dispositionMember.asi_status == 2) {
                                departmentRow.innerHTML += ` - зарезервировано для ликвидации`
                            } else {
                                departmentRow.innerHTML += ` - информации о данной службе нет`
                            }

                            departments.appendChild(departmentRow)
                        }

                        memberRow.appendChild(departments)

                        if(dispositionMember.departure == 1 && dispositionMember.departure_timestamp != null) {
                            memberRow.innerHTML += `
                            <div class="alert alert-success mt-2" role="alert">
                                Дата и время выезда взвода: ${dispositionMember.departure_timestamp}
                            </div>
                            `
                        } else {
                            if(dispositionMember.alert == 2) {
                                memberRow.innerHTML += `
                                <div class="alert alert-info mt-2" role="alert">
                                    Взвод получил сообщение об аварии и готовится к выезду
                                </div>
                                `
                            } else if (dispositionMember.alert == 1) {
                                memberRow.innerHTML += `
                                <div class="alert alert-warning mt-2" role="alert">
                                    Взвод ещё не отреагировал на сообщение об аварии
                                </div>
                                `
                            } else {
                                memberRow.innerHTML += `
                                <div class="alert alert-danger mt-2" role="alert">
                                    Взвод не получил сообщение об аварии
                                </div>
                                `
                            }
                            
                        }
                        
                    }
                    
                    vgsvsList.appendChild(memberRow)
                })

                vgsvsToLiquidation.appendChild(vgsvsList)

            } else {
                cardBody.innerHTML += `
                <h5 class="card-title mt-4">
                    Список оставшихся отделений для каждого ВГСВ
                </h5>
                `

                let vgsvsAndFreeDepartments = document.createElement('ul')

                dispositionMembers = Object.values(data.dispositions[accident.id])

                dispositionMembers.forEach(dispositionMember => {
                    let vgsvRow = document.createElement('li')

                    vgsvRow.innerHTML += `${dispositionMember.vgsv_name}`

                    if(Object.keys(dispositionMember.statuses).length !== 0) {
                        let departmentsColumn = document.createElement('ul')

                        if(dispositionMember.statuses.duty_department_status == 1) {
                            departmentsColumn.innerHTML += `<li>Дежурное отделение</li>`
                        }

                        if(dispositionMember.statuses.reserve_department_status == 1) {
                            departmentsColumn.innerHTML += `<li>Резервное отделение</li>`
                        }

                        if(dispositionMember.statuses.oto_status == 1) {
                            departmentsColumn.innerHTML += `<li>ОТО</li>`
                        }

                        if(dispositionMember.statuses.sds_status == 1) {
                            departmentsColumn.innerHTML += `<li>СДС</li>`
                        }

                        if(dispositionMember.statuses.mber_status == 1) {
                            departmentsColumn.innerHTML += `<li>МБЭР</li>`
                        }

                        if(dispositionMember.statuses.kil_status == 1) {
                            departmentsColumn.innerHTML += `<li>КИЛ</li>`
                        }

                        if(dispositionMember.statuses.asi_status == 1) {
                            departmentsColumn.innerHTML += `<li>АСИ</li>`
                        }

                        if(dispositionMember.statuses.apo_status == 1) {
                            departmentsColumn.innerHTML += `<li>АПО</li>`
                        }

                        vgsvRow.appendChild(departmentsColumn)

                    } else {
                        vgsvRow.innerHTML += ` — по какой-то причине не заступил на смену (поддержание связи возможно в телефонном режиме)`
                    }

                    vgsvsAndFreeDepartments.appendChild(vgsvRow)
                })

                vgsvsToLiquidation.appendChild(vgsvsAndFreeDepartments)
            }

            cardBody.appendChild(vgsvsToLiquidation)

            if(accident.admin_checked == false) {
                let accidentConfirmationForm = document.createElement('div')

                accidentConfirmationForm.innerHTML += `
                <form action="/CALL_VGSO/admin/${data.currentUserId}/accident/${accident.id}/confirm" method="post">
                    <input type="hidden" name="__token" value="${data.token}">
                    <div class="d-grid"><button class=\'btn btn-primary mt-3 submit-button\' type=\'submit\' style="font-size: 18px;">Подтвердить получение сообщения</button></div>
                    </form>
                `
                cardBody.appendChild(accidentConfirmationForm)
            } else {
                let liquidateForm = document.createElement('div')

                liquidateForm.innerHTML += `
                    <form action="/CALL_VGSO/admin/${data.currentUserId}/accident/${accident.id}/liquidate" method="post">
                        <input type="hidden" name="__token" value="${data.token}">
                        <div class="d-grid"><button class=\'btn btn-primary mt-3 submit-button\' type=\'submit\' style="font-size: 18px;">Сообщить о ликвидации</button></div>
                    </form>
                `
    
                cardBody.appendChild(liquidateForm);
            }

            accidentCard.appendChild(cardHeader);
            accidentCard.appendChild(cardBody);

            mainInfo.appendChild(accidentCard);
        })
    } else {
        let withoutAccidentsCard = document.createElement('div');
        withoutAccidentsCard.classList.add('card')

        withoutAccidentsCard.innerHTML += `
        <div class="card-body">
            <div class="card-text" style="font-size: 20px;">
                <p>При возникновении аварии в этом окне отобразится информация о ней!!!</p> 
                <p>В межаварийный период оперативный состав ВГСВ занимается профессиональной подготовкой.</p>
            </div>
        </div>
        `

        mainInfo.appendChild(withoutAccidentsCard)
    }

    mainTable.appendChild(tableBody);

    changesTable.appendChild(mainTable);

}

function vgsvApp(data) {

    /* блок, куда будет интегрирована таблица */
    const tableBlock = document.querySelector('#statuses-table')
    tableBlock.innerHTML = ''

    /* блок, куда будет интегрироваться карточка смены */
    const changeCardBlock = document.querySelector('#change-card-block')
    if(changeCardBlock != null) {
        changeCardBlock.innerHTML = ''
    }

    const emptyChangeCardBlock = document.querySelector('#empty-change-card-block')
    if(emptyChangeCardBlock != null) {
        emptyChangeCardBlock.innerHTML = ''
    }

    const accidentInfoForVgsv = document.querySelector('#accident-info-for-vgsv')
    if(accidentInfoForVgsv != null) {
        accidentInfoForVgsv.innerHTML = ''
    }

    /* Оформление таблицы статусов */
    let statusesTableBlock = document.createElement('div');
    statusesTableBlock.classList.add('overflow-x-auto', 'bg-light', 'pt-5', 'pb-5', 'pe-4', 'ps-4')
    statusesTableBlock.style.borderRadius = '15px'

    let statusesTable = document.createElement('table')
    statusesTable.classList.add('table')

    statusesTable.innerHTML += `
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col" style="text-align: center;"><span class="th-with-condition-620-rotate">В сети</span></th>
            <th scope="col" style="text-align: center;"><span class="th-with-condition-620-rotate">Оповещение</span></th>
            <th scope="col" style="text-align: center;"><span class="th-with-condition-620-rotate">Выезд</span></th>
        </tr>
    </thead>
    `

    let statusesTableBody = document.createElement('tbody')

    let statusesRow = document.createElement('tr')

    statusesRow.innerHTML += `
    <td class="pe-5 pt-3" style="font-size: 20px; word-wrap: break-word;">
        ${data.currentUser.name}
    </td>
    `

    let onlineIndicator = document.createElement('td');
    onlineIndicator.classList.add('pe-3', 'pt-3')
    onlineIndicator.style.textAlign = 'center'
    onlineIndicator.style.wordBreak = 'break-all'

    if(data.currentUser.online == 1) {
        onlineIndicator.innerHTML += `<div class="indicator green"></div>`
    } else {
        onlineIndicator.innerHTML += `<div class="indicator red"></div>`
    }

    let alertIndicator = document.createElement('td');
    alertIndicator.classList.add('pe-3', 'pt-3')
    alertIndicator.style.textAlign = 'center'
    alertIndicator.style.wordBreak = 'break-all'

    if(data.currentUser.alert == 1) {
        alertIndicator.innerHTML += `<div class="indicator yellow"></div>`
    } else if (data.currentUser.alert == 2) {
        alertIndicator.innerHTML += `<div class="indicator green"></div>`
    } else {
        alertIndicator.innerHTML += `<div class="indicator red"></div>`
    }

    let departureIndicator = document.createElement('td');
    departureIndicator.classList.add('pe-3', 'pt-3')
    departureIndicator.style.textAlign = 'center'
    departureIndicator.style.wordBreak = 'break-all'

    if(data.currentUser.departure == 0) {
        departureIndicator.innerHTML += `<div class="indicator red"></div>`
    } else {
        departureIndicator.innerHTML += `<div class="indicator green"></div>`
    }

    statusesRow.appendChild(onlineIndicator)

    statusesRow.appendChild(alertIndicator)

    statusesRow.appendChild(departureIndicator)

    statusesTableBody.appendChild(statusesRow)

    statusesTable.appendChild(statusesTableBody)

    statusesTableBlock.appendChild(statusesTable)

    /* интеграция таблицы в её блок */
    tableBlock.appendChild(statusesTableBlock)

    /* Работа с таблицей окончена */



    /* оформление вывода данных о текущей смене */
    let changeCard = document.createElement('div');
    changeCard.classList.add('card', 'mt-4', 'mb-4')

    if(Object.keys(data.lastChange) == 0 || data.lastChange.end_timestamp != null) {
        let cardBody = document.createElement('div')
        cardBody.classList.add('card-header')

        let textCard = document.createElement('div')
        textCard.classList.add('text-card')
        textCard.style.fontSize = '18px'

        textCard.innerHTML += `Смена ещё не начата. `

        if(data.lastChange.end_timestamp != null) {
            textCard.innerHTML += `Последняя смена была окончена ${data.lastChange.end_timestamp}. `
        }

        cardBody.appendChild(textCard)

        cardBody.innerHTML += `
        <div class="d-grid mt-4">
            <a href="/CALL_VGSO/vgsv/${data.currentUserId}/newchange" type="button" class="btn btn-primary">Заступить на смену</a>
        </div>
        `

        changeCard.appendChild(cardBody)

        emptyChangeCardBlock.appendChild(changeCard)
    } else {
        let cardHeader = document.createElement('div')
        cardHeader.classList.add('card-header')
        cardHeader.style.fontSize = '30px'

        cardHeader.innerHTML += `Информация о текущей смене`

        let cardBody = document.createElement('div')
        cardBody.classList.add('card-body');

        cardBody.innerHTML += `
        <h4 class="mt-3">Информация о дежурной смене</h4>
        <h5 class="card-title mt-3 ms-3">
            Старший командир дежурной смены:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.duty_department_senior_commander_name}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Номер телефона старшего командира дежурной смены:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.duty_department_senior_commander_telephone_number}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Номер дежурного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.duty_department_number}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Командир дежурного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.duty_department_commander_name}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Номер телефона командира дежурного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.duty_department_commander_telephone_number}
        </p>

        <h5 class="card-title mt-3 ms-3">
            Марка и госномер автомобиля дежурного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.duty_department_vehicle}
        </p>

        <h4 class="mt-5">Информация о резервной смене</h4>
        <h5 class="card-title mt-3 ms-3">
            Старший командир резервной смены:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.reserve_department_senior_commander_name}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Номер телефона старшего командира резервной смены:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.reserve_department_senior_commander_telephone_number}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Номер резервного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.reserve_department_number}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Командир резервного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.reserve_department_commander_name}
        </p>
        
        <h5 class="card-title mt-3 ms-3">
            Номер телефона командира резервного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.reserve_department_commander_telephone_number}
        </p>

        <h5 class="card-title mt-3 ms-3">
            Марка и госномер автомобиля резервного отделения:
        </h5>
        <p class="card-text ms-5">
            ${data.lastChange.reserve_department_vehicle}
        </p>
        `

        if(data.lastChange.oto_duty_name != '' || data.lastChange.oto_duty_telephone_number != '') {
            
            cardBody.innerHTML += `<h4 class="mt-5">Информация об ОТО:</h4>`

            if(data.lastChange.oto_duty_name != '') {
                cardBody.innerHTML += `
                <h5 class="ms-3 mt-4 ms-3">
                    Дежурный ОТО:
                </h5>
                <p class="card-text mt-2 ms-5">
                    ${data.lastChange.oto_duty_name}
                </p>
                `
            }

            if(data.lastChange.oto_duty_telephone_number != '') {
                cardBody.innerHTML += `
                <h5 class="ms-3 mt-4 ms-3">
                    Номер телефона дежурного ОТО:
                </h5>
                <p class="card-text mt-2 ms-5">
                    ${data.lastChange.oto_duty_telephone_number}
                </p>
                `
            }

        }

        if(data.lastChange.sds_duty_name != '' || data.lastChange.sds_duty_telephone_number != '') {
            
            cardBody.innerHTML += `<h4 class="mt-5">Информация об CДС:</h4>`

            if(data.lastChange.sds_duty_name != '') {
                cardBody.innerHTML += `
                <h5 class="ms-3 mt-4 ms-3">
                    Дежурный СДС:
                </h5>
                <p class="card-text mt-2 ms-5">
                    ${data.lastChange.sds_duty_name}
                </p>
                `
            }

            if(data.lastChange.sds_duty_telephone_number != '') {
                cardBody.innerHTML += `
                <h5 class="ms-3 mt-4 ms-3">
                    Номер телефона дежурного СДС:
                </h5>
                <p class="card-text mt-2 ms-5">
                    ${data.lastChange.sds_duty_telephone_number}
                </p>
                `
            }

        }

        if(data.lastChange.mber_duty_name != '' || data.lastChange.mber_duty_telephone_number != '' || data.lastChange.mber_vehicle) {
            
            cardBody.innerHTML += `<h4 class="mt-5">Информация об МБЭР:</h4>`

            if(data.lastChange.mber_duty_name != '') {
                cardBody.innerHTML += `
                <h5 class="ms-3 mt-4 ms-3">
                    Дежурный МБЭР:
                </h5>
                <p class="card-text mt-2 ms-5">
                    ${data.lastChange.mber_duty_name}
                </p>
                `
            }

            if(data.lastChange.mber_duty_telephone_number != '') {
                cardBody.innerHTML += `
                <h5 class="ms-3 mt-4 ms-3">
                    Номер телефона дежурного МБЭР:
                </h5>
                <p class="card-text mt-2 ms-5">
                    ${data.lastChange.mber_duty_telephone_number}
                </p>
                `
            }

            if(data.lastChange.mber_vehicle != '') {
                cardBody.innerHTML += `
                <h5 class="ms-3 mt-4 ms-3">
                    Марка и госномер автомобиля МБЭР:
                </h5>
                <p class="card-text mt-2 ms-5">
                    ${data.lastChange.mber_vehicle}
                </p>
                `
            }

        }

        cardBody.innerHTML += `
        <h4 class="card-title mt-5">
            Группировка сил на смене:
        </h4>
        <h5 class="ms-3 mt-4 ms-3">Человек</h5>
        <p class="card-text ms-5">
            ${data.lastChange.people_forces}
        </p>
        <h5 class="ms-3 mt-4 ms-3">Автомобилей</h5>
        <p class="card-text ms-5">
            ${data.lastChange.auto_forces}
        </p>

        <div class="d-grid">
            <a href="/CALL_VGSO/vgsv/${data.currentUserId}/endchange" class="btn btn-primary">
                Завершить смену
            </a>
        </div>
        `

        changeCard.appendChild(cardHeader)
        changeCard.appendChild(cardBody)
        
        changeCardBlock.appendChild(changeCard)
    }
    /* Работа с оформлением данных о текущей смене окончена */




    /* Вывод информации об авариях */
    let currentAccidentsBlock = document.createElement('div')
    if (accidentInfoForVgsv != null) {

        if(data.currentAccidents.some(() => true)) {

            data.currentAccidents.forEach(currentAccident => {
                if(currentAccident.status == 1) {
                    
                    dispositionMembers = Object.values(data.dispositions[currentAccident.id])
    
                    dispositionMembers.forEach(dispositionMember => {
                        if(data.currentUserId == dispositionMember.vgsv) {
                            let accidentCard = document.createElement('div')
                            accidentCard.classList.add('card', 'mb-4')
            
                            let cardHeader = document.createElement('div')
                            cardHeader.classList.add('card-header')
                            cardHeader.style.fontSize = '30px'
            
                            cardHeader.innerHTML += `Информация об аварии`
            
                            let cardBody = document.createElement('div')
                            cardBody.classList.add('card-body')
            
                            if(dispositionMember.current_change != null) {
                                cardBody.innerHTML += `
                                <h5 class="card-title mt-3">
                                    Набор необходимых служб для выезда:
                                </h5>
                                `

                                if(data.lastChange.id != dispositionMember.current_change) {
                                    cardBody.innerHTML += `
                                    <div class="alert alert-warning" role="alert">
                                        Информация о службах отображается на основе <a href="/CALL_VGSO/vgsv/${dispositionMember.vgsv}/change/${dispositionMember.current_change}">другой смены</a>!!! Не текущей!!!
                                    </div>
                                    `
                                }
    
                                let departmentsToDeparture = document.createElement('div')
                                departmentsToDeparture.classList.add('card-text')
    
                                let departmentsToDepartureList = document.createElement('ul')
    
                                if(dispositionMember.necessaryDepartments.duty_department == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `Дежурное отделение`
    
                                    if(dispositionMember.duty_department_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                if(dispositionMember.necessaryDepartments.reserve_department == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `Резервное отделение`
    
                                    if(dispositionMember.reserve_department_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                if(dispositionMember.necessaryDepartments.mber == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `МБЭР`
    
                                    if(dispositionMember.mber_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                if(dispositionMember.necessaryDepartments.oto == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `ОТО`
    
                                    if(dispositionMember.oto_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                if(dispositionMember.necessaryDepartments.kil == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `КИЛ`
    
                                    if(dispositionMember.kil_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                if(dispositionMember.necessaryDepartments.sds == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `СДС`
    
                                    if(dispositionMember.sds_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                if(dispositionMember.necessaryDepartments.apo == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `АПО`
    
                                    if(dispositionMember.apo_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                if(dispositionMember.necessaryDepartments.asi == 1) {
                                    let departmentRow = document.createElement('li')
    
                                    departmentRow.innerHTML += `АСИ`
    
                                    if(dispositionMember.asi_status == 2) {
                                        departmentRow.innerHTML += ` — зарезервировано под ликвидацию`
                                    } else {
                                        departmentRow.innerHTML += ` — информации о данной службе нет`
                                    }
    
                                    departmentsToDepartureList.appendChild(departmentRow)
                                }
    
                                departmentsToDeparture.appendChild(departmentsToDepartureList)
    
                                cardBody.appendChild(departmentsToDeparture)
    
                                cardBody.innerHTML += `
                                <h5 class="card-title mt-3">
                                    Шахта, на которой произошла авария:
                                </h5>
                                <div class="card-text">
                                    ${currentAccident.mine_name}
                                </div>
        
                                <h5 class="card-title mt-3">
                                    Вид аварии:
                                </h5>
                                <div class="card-text">
                                    ${currentAccident.accident_name}
                                </div>

                                <h5 class="card-title mt-3">
                                    Дата и время аварии:
                                </h5>
                                <div class="card-text">
                                    ${currentAccident.accident_timestamp}
                                </div>

                                <h5 class="card-title mt-3">
                                    Дата и время оповещения об аварии :
                                </h5>
                                <div class="card-text">
                                    ${currentAccident.send_timestamp}
                                </div>
                                `

                                if(dispositionMember.alert == 2) {
                                    cardBody.innerHTML += `
                                    <div class="bg-warning mt-2" style="text-align: center; font-size: 20px; color: white; border-radius: 5px;">
                                        Сообщение отмечено как полученное
                                    </div>
                                    `
                                    if(dispositionMember.departure == 1) {
                                        cardBody.innerHTML += `
                                        <div class="bg-warning mt-2" style="text-align: center; font-size: 20px; color: white; border-radius: 5px;">
                                            Дата и время выезда: ${dispositionMember.departure_timestamp}
                                        </div>
                                        `
                                    } else {
                                        cardBody.innerHTML += `
                                        <form action="/CALL_VGSO/vgsv/${data.currentUserId}/accident/${currentAccident.id}/departure" method="post">
                                            <input type="hidden" name="__token" value="${data.token}">
                                            <div class="d-grid"><button class=\'btn btn-primary mt-3 submit-button\' type=\'submit\' style="font-size: 18px;">Оповестить систему о выезде</button></div>
                                        </form>
                                        `
                                    }
                                } else {
                                    cardBody.innerHTML += `

                                    <form action="/CALL_VGSO/vgsv/${data.currentUserId}/accident/${currentAccident.id}/havealert" method="post">
                                        <input type="hidden" name="__token" value="${data.token}">
                                        <div class="d-grid"><button class=\'btn btn-primary mt-3 submit-button\' type=\'submit\' style="font-size: 18px;">Отметить сообщение прочитанным</button></div>
                                    </form>
                                    `

                                }
                            } else {
                                cardBody.innerHTML += `
                                <div class="card-text">
                                    Вы на смену зашли после получения сообщения об аварии, поэтому подключите смену к аварии прежде чем отправить отметку о получении сообшения!
                                </div>
    
                                <form action="/CALL_VGSO/vgsv/${data.currentUserId}/accident/${currentAccident.id}/change/${data.lastChange.id}/add" method="post">
                                        <input type="hidden" name="__token" value="${data.token}">
                                        <div class="d-grid"><button class=\'btn btn-primary mt-3 submit-button\' type=\'submit\' style="font-size: 18px;">Внести текущую смену в список ликвидаторов</button></div>
                                    </form>
                                `
                            }
            
                            accidentCard.appendChild(cardHeader)
                            accidentCard.appendChild(cardBody)
    
                            currentAccidentsBlock.appendChild(accidentCard)
    
                        }
                    })
                    
                }
            })
        }

        accidentInfoForVgsv.appendChild(currentAccidentsBlock)

    }

}