//If here is using shallowMount, some elements in BootstrapVue will be lost during render.
import {
    mount,
    createLocalVue
} from '@vue/test-utils';
import Component from './TaskList'; // name of your Vue component
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';

let mock = new MockAdapter(axios);

describe('TaskList vue.', () => {
    const localVue = createLocalVue()
    localVue.use(BootstrapVue)

    const addTask = jest.fn()
    const getTasks = jest.fn()
    const onFiltered = jest.fn();
    const catchFn = jest.fn();
    let wrapper;

    beforeEach(() => {
        wrapper = mount(Component, {
            localVue,
            methods: {
                getTasks,
                addTask,
                onFiltered
            }
        });
    });

    afterEach(() => {
        wrapper.destroy();
    });
    it('Show tasks list', () => {
        mock.onGet('/tasks/index').reply(200, {
            response: [{
                    id: 3,
                    user_id: 1,
                    name: "Omnis aut vel et nobis et.",
                    finished_at: null,
                    created_at: "2019-08-04 14:36:47",
                    updated_at: "2019-08-04 14:36:47"
                },
                {
                    id: 4,
                    user_id: 1,
                    name: "Impedit quos cum non cumque enim.",
                    finished_at: null,
                    created_at: "2019-08-04 14:36:47",
                    updated_at: "2019-08-04 14:36:47"
                },
                {
                    id: 9,
                    user_id: 1,
                    name: "Create tasks",
                    finished_at: "2019-08-04 14:36:55",
                    created_at: "2019-08-04 14:36:55",
                    updated_at: "2019-08-04 14:36:55"
                }
            ]
        });

        axios.get('/tasks/index')
            .then(function (response) {
                expect(response.data.response.length).toBe(3);
                expect(response.data.response[0].user_id).toBe(1);
                expect(response.data.response[0].id).toBe(3);
            });
        expect(getTasks.mock.calls.length).toBe(1);
        expect(catchFn).not.toHaveBeenCalled();
    });
    it('has my-1 class', () => {
        expect(wrapper.contains('.my-1')).toBe(true);
    });
    it('has a button', () => {
        expect(wrapper.contains('button')).toBe(true)
    });
    it('Create task input is empty', () => {
        expect(wrapper.vm.newTask).toBe('')
    });
    it('Click "Create a new task" when input is an empty', () => {
        expect(wrapper.vm.newTask).toBe('')
        wrapper.find('.btn-primary').find('button').trigger('click');
        expect(wrapper.vm.newTask).toBe('')
    });
    it('Input test into create task', () => {
        wrapper.setData({
            newTask: 'test'
        })
        expect(wrapper.vm.newTask).toBe('test')
    });
    it('Click "Create a new task" when input is test', () => {
        expect(wrapper.vm.newTask).toBe('')
        wrapper.setData({
            newTask: 'test'
        })
        expect(addTask.mock.calls.length).toBe(0)
        wrapper.find('.btn-primary').find('button').trigger('click')
        expect(addTask.mock.calls.length).toBe(1)
        expect(catchFn).not.toHaveBeenCalled();
    });
    it('Search filter input empty', () => {
        expect(onFiltered.mock.calls.length).toBe(0)
        wrapper.setData({
            filter: 'test'
        })
        expect(onFiltered.mock.calls.length).toBe(1)
        wrapper.find('.btn-dark').find('button').trigger('click')
        expect(onFiltered.mock.calls.length).toBe(2)
        expect(wrapper.vm.filter).toBe('')
    });
    it('Search filter input something', () => {
        expect(onFiltered.mock.calls.length).toBe(2)
        wrapper.setData({
            filter: 'test'
        })
        expect(onFiltered.mock.calls.length).toBe(3)
    })
});
