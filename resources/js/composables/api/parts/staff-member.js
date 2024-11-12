export const staffMemberPartsAPI = ky => {
  return {
    async getDepartments(siteId = null) {
      return await ky(`staff_member/departments`, {
        method: 'get',
        searchParams: siteId ? { siteId } : null
      }).json()
    },
    async getItemsByDepartment(
      categorized,
      departmentIds,
      allDepartments,
      itemCount,
      siteId = ''
    ) {
      categorized = categorized ? 1 : 0

      const usp = new URLSearchParams()
      usp.append('categorized', categorized)
      departmentIds.forEach(id => usp.append('departmentIds[]', id))
      usp.append('allDepartments', allDepartments)

      usp.append('itemCount', itemCount)
      usp.append('siteId', siteId)

      return await ky(`staff_member/items_by_department`, {
        method: 'get',
        searchParams: usp
      }).json()
    }
  }
}
