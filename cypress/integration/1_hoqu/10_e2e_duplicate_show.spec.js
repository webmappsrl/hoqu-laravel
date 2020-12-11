
describe('Page Duplicate Check Father', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('e2e1', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()

        cy.get('span#link_duplicate').click()

        //ASSERT archive
        cy.url().should('contain', '/duplicate')

        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1) > div').invoke('text').then((duplicate_id) => {

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2) > div > a').invoke('text').then((instance) => {


                cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(3) > div > a').invoke('text').then((job) => {


                    cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(4) > div > a').invoke('text').then((param) => {


                        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(6) > a').invoke('text').then((date) => {


                            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(7) > a').invoke('text').then((task_id) => {
                                cy.log(task_id)
                                cy.log(date)
                                cy.log(param)
                                cy.log(job)
                                cy.log(instance)
                                cy.log(duplicate_id)

                                //check value {duplicate_id}/show_duplicate

                                cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1) > div > div > a').click()

                                cy.get('#idTask').invoke('text').then((d_id) => {
                                    var id = duplicate_id.split('\n ')[1]
                                    id = id.split('                              ')[1]
                                    expect(d_id).to.contain(id)
                                })

                                cy.get('#idFather > a').invoke('text').then((t_id) => {
                                    expect(t_id).to.contain(task_id)
                                })

                                cy.get('#idInstance').invoke('text').then((inst) => {
                                    expect(inst).to.contain(instance)
                                })

                                cy.get('#idJob').invoke('text').then((j) => {
                                    expect(j).to.contain(job)
                                })

                                cy.get('#idParameters').invoke('text').then((p) => {
                                    expect(p).to.contain(param)
                                })

                                cy.get('#idCreated').invoke('text').then((c) => {
                                     expect(c).to.contain(date)
                                })

                                cy.get('h4#processStatus').each(($e, index, $list) => {
                                    const text = $e.text()
                                    expect(text).to.contain('duplicate')

                                })

                                //check link father and value {id}/show

                                cy.get('#idFather > a').click()

                                cy.get('#idInstance').invoke('text').then((inst1) => {
                                    expect(inst1).to.contain(instance)
                                })

                                cy.get('#idJob').invoke('text').then((j1) => {
                                    expect(j1).to.contain(job)
                                })

                                cy.get('#idParameters').invoke('text').then((p1) => {
                                    expect(p1).to.contain(param)
                                })

                                cy.get('#idTask').invoke('text').then((t) => {
                                    expect(t).to.contain(task_id)
                                })

                                cy.get('h4#processStatus').each(($e, index, $list) => {
                                    const text = $e.text()
                                    expect(text).to.contain('new')

                                })

                                cy.visit('/duplicate')

                                //check link father and {show/id}
                                cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(7) > a').click()

                                cy.get('#idInstance').invoke('text').then((inst1) => {
                                    expect(inst1).to.contain(instance)
                                })

                                cy.get('#idJob').invoke('text').then((j1) => {
                                    expect(j1).to.contain(job)
                                })

                                cy.get('#idParameters').invoke('text').then((p1) => {
                                    expect(p1).to.contain(param)
                                })

                                cy.get('#idTask').invoke('text').then((t) => {
                                    expect(t).to.contain(task_id)
                                })

                                cy.get('h4#processStatus').each(($e, index, $list) => {
                                    const text = $e.text()
                                    expect(text).to.contain('new')

                                })




                            })



                        })



                    })



                })



            })

    })



        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()



    })
})
