const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"api.students":{"uri":"api\/students","methods":["GET","HEAD"]},"api.teachers":{"uri":"api\/teachers","methods":["GET","HEAD"]},"api.classes":{"uri":"api\/classes","methods":["GET","HEAD"]},"api.exams":{"uri":"api\/exams","methods":["GET","HEAD"]},"api.exams.id":{"uri":"api\/exams\/{exam_id}","methods":["GET","HEAD"],"parameters":["exam_id"]},"api.subjects":{"uri":"api\/subjects","methods":["GET","HEAD"]},"auth.login.index":{"uri":"login","methods":["GET","HEAD"]},"auth.login.post":{"uri":"login","methods":["POST"]},"auth.logout":{"uri":"logout","methods":["GET","POST","HEAD"]},"settings.account":{"uri":"settings\/account","methods":["GET","HEAD"]},"settings.security":{"uri":"settings\/security","methods":["GET","HEAD"]},"app.dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"app.schedules.index":{"uri":"schedules","methods":["GET","HEAD"]},"app.schedules.create":{"uri":"schedules\/create","methods":["GET","HEAD"]},"app.schedules.store":{"uri":"schedules","methods":["POST"]},"app.schedules.show":{"uri":"schedules\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.schedules.edit":{"uri":"schedules\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.schedules.update":{"uri":"schedules\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.schedules.destroy":{"uri":"schedules\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.class_inventory.index":{"uri":"class_inventory","methods":["GET","HEAD"]},"app.exams.index":{"uri":"exams","methods":["GET","HEAD"]},"app.exams.create":{"uri":"exams\/create","methods":["GET","HEAD"]},"app.exams.store":{"uri":"exams","methods":["POST"]},"app.exams.show":{"uri":"exams\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.exams.edit":{"uri":"exams\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.exams.update":{"uri":"exams\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.exams.destroy":{"uri":"exams\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.subjects.index":{"uri":"subjects","methods":["GET","HEAD"]},"app.subjects.create":{"uri":"subjects\/create","methods":["GET","HEAD"]},"app.subjects.store":{"uri":"subjects","methods":["POST"]},"app.subjects.show":{"uri":"subjects\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.subjects.edit":{"uri":"subjects\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.subjects.update":{"uri":"subjects\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.subjects.destroy":{"uri":"subjects\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.students.index":{"uri":"students","methods":["GET","HEAD"]},"app.students.create":{"uri":"students\/create","methods":["GET","HEAD"]},"app.students.store":{"uri":"students","methods":["POST"]},"app.students.show":{"uri":"students\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.students.edit":{"uri":"students\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.students.update":{"uri":"students\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.students.destroy":{"uri":"students\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.teachers.index":{"uri":"teachers","methods":["GET","HEAD"]},"app.teachers.create":{"uri":"teachers\/create","methods":["GET","HEAD"]},"app.teachers.store":{"uri":"teachers","methods":["POST"]},"app.teachers.show":{"uri":"teachers\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.teachers.edit":{"uri":"teachers\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.teachers.update":{"uri":"teachers\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.teachers.destroy":{"uri":"teachers\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.classes.index":{"uri":"classes","methods":["GET","HEAD"]},"app.classes.create":{"uri":"classes\/create","methods":["GET","HEAD"]},"app.classes.store":{"uri":"classes","methods":["POST"]},"app.classes.show":{"uri":"classes\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.classes.edit":{"uri":"classes\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.classes.update":{"uri":"classes\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.classes.destroy":{"uri":"classes\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.inventory.index":{"uri":"inventory","methods":["GET","HEAD"]},"app.inventory.create":{"uri":"inventory\/create","methods":["GET","HEAD"]},"app.inventory.store":{"uri":"inventory","methods":["POST"]},"app.inventory.show":{"uri":"inventory\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.inventory.edit":{"uri":"inventory\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.inventory.update":{"uri":"inventory\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.inventory.destroy":{"uri":"inventory\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.reports.index":{"uri":"reports","methods":["GET","HEAD"]},"app.reports.create":{"uri":"reports\/create","methods":["GET","HEAD"]},"app.reports.store":{"uri":"reports","methods":["POST"]},"app.reports.show":{"uri":"reports\/{id}","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.reports.edit":{"uri":"reports\/{id}\/edit","methods":["GET","HEAD"],"parameters":["id"],"bindings":{"id":"id"}},"app.reports.update":{"uri":"reports\/{id}","methods":["PUT","PATCH"],"parameters":["id"],"bindings":{"id":"id"}},"app.reports.destroy":{"uri":"reports\/{id}","methods":["DELETE"],"parameters":["id"],"bindings":{"id":"id"}},"app.grades.index":{"uri":"grades","methods":["GET","HEAD"]},"app.student.grades.index":{"uri":"my_grades","methods":["GET","HEAD"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
