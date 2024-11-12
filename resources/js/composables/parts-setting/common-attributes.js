import { reactive, ref } from 'vue'

export const usePartsAttributes = (designPattern, attrs) => {
  const designTypes = ref([])

  const attributes = reactive({
    id: '',
    className: '',
    style: '',
    showPCView: false,
    showSPView: false,
    position: 'center',
    containerWidth: '1200px',
    containerFullSize: true,
    paddingTop: '30px',
    paddingBottom: '30px',
    textColor: '',
    backgroundColor: '',
    backGroundImage: '',
    fadein: '',
    anchor: '',
    parts: {}
  })

  const init = () => {
    designTypes.value = [...Array(designPattern)].map((_, i) => {
      return {
        designType: i + 1,
        ...attributes,
        ...attrs
      }
    })
  }

  init()

  return {
    designTypes
  }
}
