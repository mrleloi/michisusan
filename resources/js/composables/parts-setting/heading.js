import { ref } from 'vue'

export const useHeadingParts = () => {
  const designTypes = ref(
    [...Array(27)].map((_, i) => ({
      designType: i + 1,
      title: '<h2>タイトルテキスト</h2>',
      titleStyle: '',
      subtitle: '<h3>サブタイトルテキスト</h3>',
      subtitleStyle: '',
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
      anchor: ''
    }))
  )

  return {
    designTypes
  }
}
