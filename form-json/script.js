var items = []
var trealet
var json_file = null

var update_item_index = -1;
const selected_btn_bg = "#ffccd2";
const selected_btn_text = "#ff6131";
const btn_bg = "#ffffff";
const btn_text = "#93b5c6";

$(document).ready(function() {
    $('#show-main-form').prop('disabled', true)
    $('#download').css("display", "none")
    $('#update').prop('disabled', true)
    $('#add').prop('disabled', false)
    selectNavLi("#showoff")

    function resetMainForm() {
        $('#main-form input').val('')
        $('#main-form textarea').val('')
    }

    function resetItemForm() {
        $('.iinput').val('')
    }

    function resetImoreList() {
        $('#imore').val('')
        $('#imore-list').val('')
    }

    function resetItemsListView() {
        $('#items-list-rows').empty()
    }

    function selectBtn(button) {
        $(button).css("background-color", selected_btn_bg)
        $(button).find('i').css("color", selected_btn_text)
    }

    function nonSelectBtn(btn) {
        $(button).css("background-color", btn_bg)
        $(button).find('i').css("color", btn_text)
    }

    function nonSelectAllEditBtn() {
        update_item_index = -1
        $('.edit-item').css("background-color", btn_bg)
        $('.edit-item').find('i').css("color", btn_text)
        $('#update').prop('disabled', true)
        $('#add').prop('disabled', false)
    }

    // Khi chọn li, mới chỉnh css, chưa có form cho activities
    function selectNavLi(li) {
        $(li).css("border-bottom", "solid 3px skyblue")
    }

    function nonSelectNavLi(li) {
        $(li).css("border", "transparent")
    }

    function stringToNum(text) {
        let num = parseInt(text.replace(/\s/g, ''), 10)
        if (isNaN(num)) return -1;
        else if (num > 0) return num;
        else return -1;
    }

    // Chuyển dãy số lấy từ input (string) -> mảng số
    function stringToNumArray(text) {
        stringToStrArray(text).map(Number);
    }

    function stringToStrArray(text) {
        let str = text.replace(/\s/g, '');
        if (str.length == 0) {
            return [];
        }
        return str.split(',');
    }

    function addItemByInfo(image, time, idesc, more) {
        let item = {
            image: image,
            time: time,
            idesc: idesc,
            more: more
        }
        items.push(item)
    }

    function addItemByItem(item) {
        items.push(item)
    }

    function insertItemAt(index, item) {
        items.splice(index, 0, item)
    }

    function getItemHtml(no, image, time) {
        let item_view = $(document.createElement('div')).prop({
            class: "horizontal item"
        })
        let no_label = $(document.createElement('LABEL')).prop({
            class: "item-no"
        })
        no_label.html(no.toString() + ".")

        let item_box = $(document.createElement('div')).prop({
            class: "horizontal item-box"
        })
        item_view.append(no_label, item_box)
        let item_info = $(document.createElement('div')).prop({
            class: "item-info"
        })
        let label_time = $(document.createElement('SPAN')).prop({
            class: "item-view-text"
        })
        label_time.html("Thời gian: ")
        let itime_info = $(document.createElement('SPAN')).prop({
            class: "itime-info"
        })
        itime_info.html(time)
        let label_id = $(document.createElement('SPAN')).prop({
            class: "item-view-text"
        })
        label_id.html("Id: ")
        let iid_info = $(document.createElement('SPAN')).prop({
            class: "itime-info"
        })
        iid_info.html(image)
        item_info.append(label_time, itime_info, label_id, iid_info)
        let btns_container = $(document.createElement('div')).prop({
            class: "horizontal small-buttons item-btns"
        })
        let delete_btn = $(document.createElement('button')).prop({
            type: "submit",
            class: "delete-item"
        })
        delete_btn.append('<i class="fas fa-trash"></i> Xóa')
        let duplicate_btn = $(document.createElement('button')).prop({
            type: "submit",
            class: "duplicate-item"
        })
        duplicate_btn.append('<i class="fas fa-copy"></i> x2')
        let edit_btn = $(document.createElement('button')).prop({
            type: "submit",
            class: "edit-item"
        })
        edit_btn.append('<i class="fas fa-edit"></i> Chỉnh sửa')
        btns_container.append(delete_btn, duplicate_btn, edit_btn)
        item_box.append(item_info, btns_container)
        return item_view
    }

    function addItemViewHtml(no, id, time) {
        $('#items-list-rows').append(getItemHtml(no, id, time))
    }

    function renderItemsListView() {
        resetItemsListView();
        nonSelectAllEditBtn();
        for (let i = 0; i < items.length; i++) {
            addItemViewHtml(i + 1, items[i].id, items[i].time)
        }
    }

    function getIndexOfItem(item_view) {
        return item_view.closest('.item').index();
    }

    function deleteItemByIndex(index) {
        if (index >= 0 && index < items.length) {
            items.splice(index, 1);
        }
    }

    function showItemByIndex(index) {
        let item = items[index]
        resetItemForm();
        $('#iid').val(item.image)
        $('#itime').val(item.time)
        $('#idesc').val(item.idesc)
        $('#imore-list').val(item.more)
    }

    $('#showoff').click(function() {
        nonSelectNavLi("#activities")
        selectNavLi("#showoff")
    })

    $('#activities').click(function() {
        nonSelectNavLi("#showoff")
        selectNavLi("#activities")
    })

    $('#hide-main-form').click(function() {
        $('#main-form .input-container').css('display', 'none')
        $(this).prop('disabled', true)
        $('#items-list-rows').height(315)
        $('#show-main-form').prop('disabled', false)
    })

    $('#show-main-form').click(function() {
        $('#main-form .input-container').css('display', 'flex')
        $(this).prop('disabled', true)
        $('#items-list-rows').height(60)
        $('#hide-main-form').prop('disabled', false)
    })

    $('#add-imore').click(function() {
        let imore = stringToNum($('#imore').val())
        if (imore > 0) {
            if (!$('#imore-list').val()) {
                $('#imore-list').val(imore.toString())
            } else {
                $('#imore-list').val($('#imore-list').val() + ',' + imore.toString())
            }
        }
        $('#imore').val('')
    })

    $('#clear-imore-list').click(function() {
        resetImoreList()
    })

    $('#clear').click(function() {
        resetItemForm()
    })

    $('#add').click(function() {
        let image = $('#iid').val();
        let time = $('#itime').val();
        let idesc = $('#idesc').val();
        let more = stringToStrArray($('#imore-list').val());
        addItemByInfo(image, time, idesc, more);
        addItemViewHtml(items.length, image, time)
        console.log(items)
    })

    $('#update').click(function() {
        if (update_item_index >= 0 && update_item_index < items.length) {
            items[update_item_index].image = $('#iid').val();
            items[update_item_index].time = $('#itime').val();
            items[update_item_index].idesc = $('#idesc').val();
            items[update_item_index].more = stringToStrArray($('#imore-list').val());
        }
        renderItemsListView();
    })

    $(document).on('click', '.delete-item', function() {
        let index = getIndexOfItem($(this).closest('.item'));
        deleteItemByIndex(index);
        renderItemsListView();
    })


    $(document).on('click', '.duplicate-item', function() {
        let index = getIndexOfItem($(this).closest('.item'));
        let newItem = {
            image: items[index].image,
            time: items[index].time,
            idesc: items[index].idesc,
            more: items[index].more,
        }
        insertItemAt(index, newItem)
        renderItemsListView()
    })

    $(document).on('click', '.edit-item', function() {
        nonSelectAllEditBtn()
        selectBtn(this)
        update_item_index = getIndexOfItem($(this).closest('.item'))
        showItemByIndex(update_item_index)
        $('#update').prop('disabled', false)
        $('#add').prop('disabled', true)

    })

    function gatherData() {
        let exec = $('#exec').val()
        let title = $('#title').val()
        let author = $('#author').val()
        let desc = $('#desc').val()
        let bgcolor = $('#bg-color').val()
        let color = $('#text-color').val()
        trealet = { exec: exec, title: title, author: author, desc: desc, bgcolor: bgcolor, color: color, items: items }
    }

    function makeFile(text) {
        var text_data = new Blob([text], { type: 'text/plain' });
        if (json_file !== null) {
            window.URL.revokeObjectURL(json_file);
        }
        json_file = window.URL.createObjectURL(text_data);
        return json_file;
    }

    $('#save').click(function() {
        gatherData();
        let datastring = JSON.stringify({ trealet: trealet }, null, "\t");
        $("#download").attr("href", makeFile(datastring));
        $("#download").css("display", "block");
    })

    $('#new').click(function() {
        resetMainForm();
        resetItemForm();
        items = [];
        resetItemsListView();
    })

});