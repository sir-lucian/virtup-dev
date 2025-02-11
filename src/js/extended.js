function goToTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera

    const currentURL = window.location.href;
    const urlWithoutHash = currentURL.split("#")[0];
    window.history.replaceState({}, document.title, urlWithoutHash);
}

function isElementVisible(el) {
    var rect = el.getBoundingClientRect(),
        vWidth = window.innerWidth || document.documentElement.clientWidth,
        vHeight = window.innerHeight || document.documentElement.clientHeight,
        efp = function (x, y) {
            return document.elementFromPoint(x, y);
        };

    // Return false if it's not in the viewport
    if (
        rect.right < 0 ||
        rect.bottom < 0 ||
        rect.left > vWidth ||
        rect.top > vHeight
    )
        return false;

    // Return true if any of its four corners are visible
    return (
        el.contains(efp(rect.left, rect.top)) ||
        el.contains(efp(rect.right, rect.top)) ||
        el.contains(efp(rect.right, rect.bottom)) ||
        el.contains(efp(rect.left, rect.bottom))
    );
}

async function getData(path = undefined) {
    if (!path) {
        return undefined;
    } else {
        try {
            const response = await fetch(path);
            if (response) {
                const data = await response.json();
                if (data && 'data' in data) {
                    return data.data;
                } else {
                    return undefined;
                }
                
            } else {
                return undefined;
            }
        } catch (e) {
            return undefined;
        }
    }
}

async function showMemberInfo(index) {
    const fullMemberInfoBody = document.getElementById("fullMemberInfoBody");
    fullMemberInfoBody.innerHTML = `<div class="d-flex justify-content-center"><div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>`;
    $("#fullMemberInfo").modal("show");
    const members = await getData("/virtup-web/src/json/members.json");
    if (members && Array.isArray(members)){
        if (members[index] && members[index].youtube.channel_handle) {
            const rawRes = await getData('/virtup-web/services/youtubeService.php?handle=' + members[index].youtube.channel_handle);
            const response = rawRes ? await JSON.parse(rawRes) : undefined;
            if (response && 'items' in response && response.items.length === 1) {
                let viewCount = Number(response.items[0].statistics.viewCount) ?? undefined;
                let subCount = Number(response.items[0].statistics.subscriberCount) ?? undefined;

                if (viewCount) {
                    let suffix = "";
                    if (viewCount > 1000000000) {
                        viewCount = viewCount / 1000000000;
                        suffix = "B";
                    } else if (viewCount > 1000000) {
                        viewCount = viewCount / 1000000;
                        suffix = "M";
                    } else if (viewCount > 1000) {
                        viewCount = Math.round(viewCount / 1000);
                        suffix = "k";
                    }
                    viewCount = Math.round(viewCount * 100) / 100;
                    viewCount = viewCount.toString() + suffix;
                }

                if (subCount) {
                    let suffix = "";
                    if (subCount > 1000000000) {
                        subCount = subCount / 1000000000;
                        suffix = "B";
                    } else if (subCount > 1000000) {
                        subCount = subCount / 1000000;
                        suffix = "M";
                    } else if (subCount > 1000) {
                        subCount = subCount / 1000;

                        suffix = "k";
                    }
                    subCount = Math.round(subCount * 100) / 100;
                    subCount = subCount.toString() + suffix;
                }

                const info = {
                    name: members[index].name,
                    handle: members[index].youtube.channel_handle,
                    image: '/virtup-web/src/images/virtual-influencers/full/' + members[index].image_full,
                    views: viewCount,
                    subs: subCount,
                    link: 'https://www.youtube.com/' + members[index].youtube.channel_handle,
                };

                let memberHTML = "";

                memberHTML += `<div class="row justify-content-center">`;
                memberHTML += `<div class="col-lg-8">`;
                memberHTML += `<img src="${info.image}" class="w-100" loading="lazy" alt="${info.name}">`;
                memberHTML += `</div>`;
                memberHTML += `<div class="col-lg-4">`;
                memberHTML += `<div class="d-flex flex-column justify-content-center h-100">`;
                memberHTML += `<div class="bg-white p-3 rounded-top d-flex justify-content-end">`;
                memberHTML += `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`;
                memberHTML += `</div>`;
                memberHTML += `<div class="d-block px-5 pb-4 bg-white rounded-bottom">`;
                memberHTML += `<h5 class="h3 text-nowrap">${info.name}</h5>`;
                memberHTML += `<p class="text-secondary text-nowrap mb-1">${info.handle}</p>`;
                memberHTML += `<p class="mb-0 text-nowrap"><i class="bi bi-people-fill me-2 text-danger"></i>${info.subs}</p>`;
                memberHTML += `<p class="text-nowrap"><i class="bi bi-eye-fill me-2 text-danger"></i>${info.views}</p>`;
                memberHTML += `<div><a role="button" class="btn btn-outline-danger rounded fs-4 w-100" href="${info.link}"><i class="bi bi-youtube"></i></a></div>`;
                memberHTML += `</div>`;
                memberHTML += `</div>`;
                memberHTML += `</div>`;
                memberHTML += `</div>`;
                memberHTML += `</div>`;
                fullMemberInfoBody.innerHTML = memberHTML;
            }
            else {
                fullMemberInfoBody.innerHTML = `<div class="bg-white px-5 py-3 rounded text-nowrap text-center fw-bold"><i class="bi bi-exclamation-triangle-fill me-2 text-danger fs-5"></i>Failed to get YouTube data</div>`;
            }
        }
    }
}

function scrollToNextSection(id) {
    if ((window.innerHeight + Math.round(window.scrollY)) >= document.body.offsetHeight) {
        goToTop();
        document.getElementById('nextSectionIs').innerHTML = `<i class="bi bi-chevron-down"></i>`;
    } else {
        const sections = [
            'top-section',
            'virtual-influencers-section',
            'about-section',
            'contact-section'
        ];
        const targetedIndex = sections.findIndex((section) => id === section) + 1;
        if (targetedIndex < sections.length && targetedIndex >= 0) {
            const element = document.getElementById(sections[targetedIndex]);
            element.scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
        }
    }
}

function checkScrollPosition() {
    if ((window.innerHeight + Math.round(window.scrollY)) >= document.body.offsetHeight) {
        document.getElementById('nextSectionIs').innerHTML = `<i class="bi bi-chevron-up"></i>`;
    } else {
        document.getElementById('nextSectionIs').innerHTML = `<i class="bi bi-chevron-down"></i>`;
    }
}

async function loadMembers() {
    const members = await getData("/virtup-web/src/json/members.json");
    const membersShow = document.getElementById("virtual-influencers") ?? undefined;
    const membersDiv = document.getElementById("virtual-influencers-info") ?? undefined;
    if (members && membersShow && membersDiv) {
        membersShow.style.display = 'block';
        let memberHTML = "";
        let group = undefined;
        let groups = [];
        let group_codes = [];
        let indexGroup = 0;
        let indexMember = 0;
        if (Array.isArray(members)) {
            memberHTML += '<div class="d-flex flex-row justify-content-center">';
            memberHTML += '<h1 class="display-6 pb-3 mb-3 header text-center" id="virtual-influencers-title">Our Virtual Influencers</h1>';
            memberHTML += '</div>';
            let member = undefined;
            for (member of members) {
                if (!group_codes.includes(member.group_code)) {
                    groups.push({
                        group_code: member.group_code,
                        group_name: member.group_name
                    });
                    group_codes.push(member.group_code);
                }
            }
            for (group of groups) {
                memberHTML += `<div class="mt-4">`;
                memberHTML += `<h3 class="h3 text-center mb-0">${group.group_name}</h3>`;
                memberHTML += `<div class="row justify-content-center pt-4">`;
                    for (member of members) {
                        if (member.group_code === group.group_code) {
                            memberHTML += `<div class="col-lg-2 col-md-4 col-sm-6 px-2 d-flex flex-column justify-content-start"><img src="/virtup-web/src/images/virtual-influencers/profile/${member.image_profile}" class="d-block rounded-pill member-photo" role="button" style="border: solid 2px ${member.color}" alt="${member.name}" onclick="showMemberInfo(${indexMember});" id="member-btn-${indexMember}"} loading="lazy" /><div class="d-block text-center mt-4"><h4 class="h5">${member.name}</h4><p class="text-secondary">${member.youtube.channel_handle}</p></div></div>`;
                            indexMember++;
                        }
                    }
                memberHTML += '</div>';
                memberHTML += '</div>';
                indexGroup++;
                if (indexGroup === groups.length - 1) {
                    memberHTML += '<hr class="w-50 mx-auto my-5" />';
                }
            }
        }
        membersDiv.innerHTML = memberHTML;
    }
}