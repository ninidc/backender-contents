import router from '../../../router';

import {
    LAYOUT_SELECT,
    LAYOUT_CANCEL,
    UPDATE_PAGE_LAYOUT
} from "../constants/";

export function selectLayout() {
    return { type: LAYOUT_SELECT };
};

export function cancelLayout() {
    return {
        type: LAYOUT_CANCEL
    };
};

export function saveSelectedLayout(layoutId) {

    return (dispatch) => {
        var route = router.route('pagelayouts.show', {
            'pageLayout?': layoutId
        });

        axios.get(route)
            .then((response) => {
                dispatch({
                    type: UPDATE_PAGE_LAYOUT,
                    payload: {
                        layout: JSON.parse(response.data.definition),
                        settings: JSON.parse(response.data.settings)
                    }
                });
                toastr.success(Lang.get('modals.loaded_template'));
            })
            .catch((error) => {
                toastr.error(Lang.get('fields.error') + ' !');
            });
    }

}
