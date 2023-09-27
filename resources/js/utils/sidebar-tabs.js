import { createGlobalState } from '@vueuse/core'
import { ref, watch } from 'vue'
import componentResolver from './sidebar-tabs/component-resolver'
import { useDialog } from '@utils'

export default createGlobalState(() => {
  const { chatData: dialog } = useDialog()
  const list = [
    { label: 'Все', value: 'all' },
    { label: 'Неотвеченные', value: 'unanswered' },
    { label: 'Важные', value: 'favorites' },
  ]

  const query = location.search.substring(1);
  
  const searchParams = new URLSearchParams(query);
  let searchValDefault = searchParams.get('search')
  let searchValDefaultIsSet = false
  const filterValDefault = searchParams.get('filter')
  const isDefaultFilterValid = list.some(element => {
    return element.value === filterValDefault;
  });
  
  const visible = ref(searchValDefault ? true : false)

  const node = ref(null)
  const active = ref(isDefaultFilterValid ? filterValDefault : 'all')
  const searchVal = ref(searchValDefault)
  
  const component = componentResolver(active, searchVal)

  const change = (tab) => {
    active.value = tab.value

    const url = location.toString().replace(location.search, "")
    const query = location.search.substring(1);

    const searchParams = new URLSearchParams(query);
    
    if (tab.value == 'unanswered' || tab.value == 'favorites') {
      searchParams.set('filter', tab.value)
      searchParams.delete('search')
    } else {
      searchParams.delete('filter')
    }
    
    let queryString = '';
    if (searchParams.toString()) {
      queryString = '?'+searchParams.toString()
    }

    window.history.pushState(null,null,url+queryString);
  }

  const show = () => {
    visible.value = true;
  }

  const hide = () => {
    visible.value = false;

    setSearchVal(null);
  }

  watch(node, async (newVal, oldVal) => {
    if (newVal && !oldVal && searchValDefaultIsSet) {
      node.value.value = ''
    }

    searchValDefaultIsSet = true;
  })
  
  const setSearchVal = (val) => {
    searchValDefault = null;
    searchVal.value = val

    const url = location.toString().replace(location.search, "")
    const query = location.search.substring(1);

    const searchParams = new URLSearchParams(query);
    if (val) {
      searchParams.set('search', val);
      searchParams.delete('filter');
    } else {
      searchParams.delete('search');
      if (active.value != 'all') {
        searchParams.set('filter', active.value);
      }
    }
    
    let queryString = '';
    if (searchParams.toString()) {
      queryString = '?'+searchParams.toString()
    }

    window.history.pushState(null,null,url+queryString);
  }

  let timeout;
  
  const events= {
    blur: (e) => {
      if (e.target.value && node.value) {
        node.value.focus()
      } else {
        hide()
      }
    },
    change: (e) => {
      setSearchVal(e.target.value)
    },
    keydown: (e) => {
      if (e.key == 'Escape' && dialog.chat == null) {
        hide()
        e.target.value = ''
      }
    },
    input: (e) => {
      clearTimeout(timeout);

      // if (e.target.value) {
      timeout = setTimeout(function () {
        setSearchVal(e.target.value)
      }, 600);
      // }
    }
  }
  
  return {
    visible,
    node,
    list,
    active,
    searchVal,
    searchValDefault,
    filterValDefault,
    component,
    change,
    events,
    show,
    hide
  }
})
